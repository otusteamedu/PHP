#!/usr/bin/env bash

docker-compose down
docker volume prune -f
docker-compose build