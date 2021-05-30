#!/bin/bash

docker-compose up -d
sleep 5
clear
docker-compose exec app php bin/console messenger:start
