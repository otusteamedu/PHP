#!/bin/bash

docker-compose up -d

docker-compose exec client php console/app.php client
