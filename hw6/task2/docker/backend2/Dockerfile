FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app