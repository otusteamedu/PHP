#!/bin/bash

docker-compose build

docker-compose run app1 composer install

