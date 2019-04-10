FROM php:7.1-fpm

RUN apt-get update && apt-get install -y curl wget git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer --version

WORKDIR /app