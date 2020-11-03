#!/bin/bash

sudo docker run --rm -v $(pwd)/etc/ssl:/certificates -e "SERVER=localhost" jacoelho/generate-certificate

sudo docker stop  $(docker inspect -f '{{.Name}}' $(docker-compose ps -q php) | cut -c 2- )
sudo docker stop  $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- )

sudo docker stop $(docker ps -a -q  --filter ancestor=wernight/ngrok)

sudo docker pull gtriggiano/ngrok-tunnel

sudo docker-compose up --build -d
sudo docker network create net
sudo docker network connect net  $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- )

echo "Start tunel with random url ..."
sudo docker run --network net --rm -it wernight/ngrok ngrok  http  $(docker inspect -f '{{.Name}}' $(docker-compose ps -q web) | cut -c 2- ):80


