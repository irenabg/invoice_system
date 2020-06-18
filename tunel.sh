#!/bin/bash

sudo docker run --rm -v $(pwd)/etc/ssl:/certificates -e "SERVER=localhost" jacoelho/generate-certificate

sudo docker stop yeptextdocker_web_1
sudo docker stop $(docker ps -a -q  --filter ancestor=wernight/ngrok)

sudo docker pull gtriggiano/ngrok-tunnel

sudo docker-compose up --build -d
sudo docker network create mynet_kosher
sudo docker network connect mynet_kosher kosherkaddy_web_1

echo -n "Do you wish to start cron process (y/n)? "
read answer

# if echo "$answer" | grep -iq "^y" ;then

if [ "$answer" != "${answer#[Yy]}" ] ;then
sudo docker exec -i $(sudo docker-compose ps -q php) bash -c "service cron start"
else
sudo docker exec -i $(sudo docker-compose ps -q php) bash -c "service cron stop"
fi

echo -n "Do you want to create / restore local DB (y/n)? "
read answer

# if echo "$answer" | grep -iq "^y" ;then

if [ "$answer" != "${answer#[Yy]}" ] ;then
sudo docker exec -i $(sudo docker-compose ps -q mysqldb) mysql -uroot -proot -e "create database kosher";
sudo docker exec -i $(sudo docker-compose ps -q mysqldb) mysql -uroot -proot kosher < "dump/kosher.sql"
else
echo "Ok skip.."
fi

mkdir web/http/templates_c
chmod -R 777  web/http/templates_c
sudo docker exec -i $(sudo docker-compose ps -q php) bash -c "php /usr/local/www/kosherkaddy.com/mysql-migrates/migrate.php run"

echo -n "Do you wish to start tunel with random url (y/n)? "
read answer

# if echo "$answer" | grep -iq "^y" ;then

if [ "$answer" != "${answer#[Yy]}" ] ;then
sudo docker run --network mynet_kosher --rm -it wernight/ngrok ngrok  http kosherkaddy_web_1:80
else
sudo docker run --network mynet_kosher --rm -it wernight/ngrok ngrok  http kosherkaddy_web_1:80
fi

