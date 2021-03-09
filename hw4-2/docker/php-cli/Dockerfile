FROM php:7.4-cli

RUN docker-php-ext-install sockets

COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /app