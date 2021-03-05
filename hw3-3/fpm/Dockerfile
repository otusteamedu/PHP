FROM php:8.0-fpm

RUN apt-get update \
    && apt-get install -y curl wget libz-dev libmemcached-dev \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && pecl install redis memcached && docker-php-ext-enable redis memcached