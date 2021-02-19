#!/bin/bash

docker-compose build

docker-compose run app composer install
