FROM php:7-fpm

ARG UID

RUN addgroup --gid $UID --system app \
    && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

RUN apt-get update && apt-get install -y \
    libzip-dev zip libpq-dev \
    && docker-php-ext-install zip sockets pdo_pgsql

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
