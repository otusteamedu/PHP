FROM php:7.3-fpm-alpine

MAINTAINER Voronin Nikita cubaman@mail.ru

RUN docker-php-ext-install sockets

WORKDIR /app
