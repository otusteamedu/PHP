#!/bin/bash

echo 'Запуск контейнеров'
docker-compose up -d
sleep 5
clear

docker-compose exec app php src/bin/console messenger:start
