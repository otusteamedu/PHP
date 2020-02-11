#!/bin/bash

echo "\nПостроение образа \n"

sudo docker build -t stream-site-image .

echo "\nЗапуск контейнера из образа \n"

sudo docker run --name stream-site-container -d -p 8080:80 stream-site-image

echo "\nПроверьте, чтобы не было ошибок \n"
echo "Откройе в браузере http://localhost:8080 \n"