FROM php:7.3-fpm-alpine

RUN apk update && apk add libpng-dev libzip libzip-dev curl-dev && apk add autoconf g++ make zip gd zip curl

RUN cd /tmp && wget -O redis.tgz https://pecl.php.net/get/redis-5.3.1.tgz && tar zxvf redis.tgz \
    && cd redis-5.3.1 && phpize && ./configure && make > /tmp/make.log && make install \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini
