FROM php:7-fpm

ARG UID

RUN addgroup --gid $UID --system app \
    && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app

RUN apt-get update && apt-get install -y \
    libzip-dev zip \
    && docker-php-ext-install zip sockets

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
