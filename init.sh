#!/usr/bin/env bash

docker build -t otus-app-image .
docker run --name otus-app -d -p 8080:80 otus-app-image
