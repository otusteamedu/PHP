#!/bin/bash

docker-compose up -d

docker-compose exec app php bin/console consumer:bank-operation
