#!/bin/bash

#пулим образ
#docker pull php:7.3-fpm-alpine

#запускаем контейнер
#docker run -d --rm --name otus-php2 -it php:7.3-fpm-alpine

#заходим в контейнер
#docker exec -it otus-php2 sh

#apk add php7-dev gcc g++ make git bash
#./rebuild.sh

#git clone https://github.com/xdebug/xdebug.git

#добавляем расширение в файл конфигурации или через docker-php-ext-enable
#echo zend_extension=xdebug.so > /usr/local/etc/php/conf.d/xdebug.ini
#или
#docker-php-ext-enable xdebug


#Проверяем
#php -v
#make > make_output.txt
#php -i | grep xdebug
