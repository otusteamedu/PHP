FROM php:7.4-cli-alpine
WORKDIR /app

ARG DEPS="git"
RUN apk add --no-cache $DEPS

ARG DEPS_PHP='opcache sockets'
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod u+x /usr/local/bin/install-php-extensions && sync && install-php-extensions $DEPS_PHP
COPY ./php.prod.ini /usr/local/etc/php/

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .
RUN composer install --no-cache --no-dev

CMD php /app/bin/server.php

ENV SOCKET_SERVER='/tmp/server.sock'
ENV SOCKET_CLIENT='/tmp/client.sock'
