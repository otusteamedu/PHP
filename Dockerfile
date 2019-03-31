FROM php

RUN apt-get update

#utils
RUN apt-get -y install git curl wget grep
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#redis
RUN pecl install -of redis
RUN docker-php-ext-enable redis

#memcached
RUN apt-get install -y libmemcached11 libmemcachedutil2 build-essential libmemcached-dev libz-dev
RUN pecl install -of igbinary msgpack memcached
RUN docker-php-ext-enable igbinary msgpack memcached

#pecl_http
RUN apt-get install -y zlib1g-dev libssl-dev libcurl4-openssl-dev
RUN pecl install -of raphf propro
RUN docker-php-ext-enable raphf propro
RUN pecl install -of pecl_http
RUN docker-php-ext-enable http

#pdo_pgsql
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
