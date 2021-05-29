#!/bin/bash

docker-compose up -d
sleep 3

docker-compose exec app composer install
docker-compose exec app php vendor/bin/doctrine orm:schema-update --force
docker-compose exec app php bin/console fake:users
docker-compose exec app php bin/console fake:bank-operations

docker-compose exec app php bin/console consumer:bank-operation

