FROM php:7.4-fpm-alpine

WORKDIR /app

COPY ./app /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install sockets

