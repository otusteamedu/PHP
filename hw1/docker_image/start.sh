#!/usr/bin/bash

docker build -t my-php-app .
docker run -it --rm --name my-running-app my-php-app