#!/bin/bash

PATH_SCRIPT=`readlink -e "$0"`
DIRECTORY=`dirname "$PATH_SCRIPT"`
cd $DIRECTORY

COUNT_ST=`docker ps | grep 'snegrey/nginx' | wc -l`
if [[ $COUNT_ST > 1 ]]
then
    echo "Запущенно более одного контейнера, перед продолжением остановите их все."
    exit 1
fi

ST=`docker ps | grep 'snegrey/nginx' | awk '{print $1}'`
if [[ $ST != '' ]]
then
    echo "Остановка работающего контейнера"
    docker stop $ST
fi

docker rm $(docker ps -a -f status=exited | grep 'snegrey/nginx' | awk '{print $1}')

docker build -t snegrey/nginx .
docker run -d -p 80:80 -v $PWD/mysite:/var/www/mysite.local  snegrey/nginx
