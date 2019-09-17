FROM php:7.3-cli as php

RUN apt update && apt install -y \
    git \
    unzip \
    --no-install-recommends \
    && docker-php-ext-install sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /src

COPY . ./

RUN composer install
