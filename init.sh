#!/bin/bash

docker-compose build

docker-compose run server composer install
