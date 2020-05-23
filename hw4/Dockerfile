FROM php:cli-alpine

RUN apk update && docker-php-ext-install sockets

COPY . /app

WORKDIR /app

ENTRYPOINT /bin/sh