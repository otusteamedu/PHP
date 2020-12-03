#!/usr/bin/bash

docker build --tag nginx_static .
docker container run --rm -p 80:80 --name static_site nginx_static