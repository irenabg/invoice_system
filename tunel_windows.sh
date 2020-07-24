#!/bin/bash
docker run --rm -v  `pwd -W`/etc/ssl:/certificates -e "SERVER=localhost" jacoelho/generate-certificate

docker stop $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- )
docker stop $(docker ps -a -q  --filter ancestor=wernight/ngrok)


docker pull gtriggiano/ngrok-tunnel


docker-compose up --build -d
docker network create mynet_kosher
docker network connect mynet_kosher $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- )

echo -n "Do you wish to start cron process (y/n)? "
read answer

# if echo "$answer" | grep -iq "^y" ;then

if [ "$answer" != "${answer#[Yy]}" ] ;then
docker exec -i $(docker-compose ps -q php) bash -c "service cron start"
else
docker exec -i $(docker-compose ps -q php) bash -c "service cron stop"
fi

echo -n "Do you want to create / restore local DB (y/n)? "
read answer

# if echo "$answer" | grep -iq "^y" ;then

if [ "$answer" != "${answer#[Yy]}" ] ;then
docker exec -i $(docker-compose ps -q mysqldb) mysql -uroot -proot -e "create database kosher";
docker exec -i $(docker-compose ps -q mysqldb) mysql -uroot -proot kosher < "dump/kosher.sql"
else
echo "Ok skip.."
fi


mkdir web/http/templates_c
chmod -R 777  web/http/templates_c
docker exec -i $(docker-compose ps -q php) bash -c "php /usr/local/www/kosherkaddy.com/mysql-migrates/migrate.php run"

echo -n "Do you wish to start tunel with random url (y/n)? "
read answer

# if echo "$answer" | grep -iq "^y" ;then

if [ "$answer" != "${answer#[Yy]}" ] ;then
winpty docker run --network mynet_kosher --rm -it wernight/ngrok ngrok  http $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- ):80
else
winpty docker run --network mynet_kosher --rm -it wernight/ngrok ngrok  http $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- ):80
fi

