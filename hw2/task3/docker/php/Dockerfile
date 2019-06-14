FROM php:7-fpm

RUN apt update && apt install -y zip git wget curl grep unzip zlib1g-dev libmemcached-dev libcurl4-openssl-dev libssl-dev libpq-dev libzip-dev

RUN docker-php-ext-install pdo_pgsql mbstring zip exif pcntl

RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install memcached && docker-php-ext-enable memcached
RUN pecl install raphf && docker-php-ext-enable raphf
RUN pecl install propro && docker-php-ext-enable propro
RUN pecl install pecl_http && docker-php-ext-enable http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer