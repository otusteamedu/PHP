FROM php:7.1-fpm

ENV TIMEZONE Europe/Moscow
ENV PHP_MEMORY_LIMIT 1024M
ENV MAX_UPLOAD 128M
ENV PHP_MAX_FILE_UPLOAD 128
ENV PHP_MAX_POST 128M

RUN apt-get update && apt-get install -y -f software-properties-common apt-utils mc wget nano git grep curl unzip tar gnupg zlib1g-dev libmemcached-dev build-essential \
    libcurl3 libpcre3-dev libcurl4-openssl-dev libpq-dev libssl-dev libssl-dev libpq5 redis-server

#RUN pecl install redis-4.0.1

RUN echo "extension=redis.so" >> $PHP_INI_DIR/conf.d/redis.ini


