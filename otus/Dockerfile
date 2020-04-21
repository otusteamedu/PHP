FROM composer:latest AS composer
FROM php:7.1-fpm
RUN apt-get update \
    && apt-get install -y bc \
        git \
        wget \
        zip\
        unzip\
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ADD ./www /var/www/html
EXPOSE 9000
