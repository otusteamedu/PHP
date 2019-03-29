#!/bin/bash
#

docker build -t pieware.pro/otus-nginx .

docker run -p 80:80 -v `pwd`:/usr/share/nginx/html pieware.pro/otus-nginx
