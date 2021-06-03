#!/bin/bash

docker-compose up -d
sleep 5

docker-compose exec app composer install
docker-compose exec app php vendor/bin/doctrine orm:schema-tool:update --force -q
docker-compose exec app php src/bin/console users:create
docker-compose exec app php src/bin/console airlines:create

docker-compose down

