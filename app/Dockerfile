FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip -y libpq-dev \
    && pecl install xdebug \
    && docker-php-ext-install pdo pdo_pgsql pgsql sockets \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app