FROM php:7.3-fpm-alpine

MAINTAINER Voronin Nikita cubaman@mail.ru

RUN docker-php-ext-install sockets

RUN apk add --no-cache bash

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && composer --version

WORKDIR /app

CMD ["tail", "-f", "/dev/null"]