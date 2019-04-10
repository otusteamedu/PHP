FROM php:7.3-fpm-alpine

MAINTAINER Voronin Nikita cubaman@mail.ru

RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer --version

WORKDIR /app

RUN composer update
