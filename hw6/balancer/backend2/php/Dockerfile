FROM php:7.2-fpm-alpine

RUN docker-php-ext-install sockets
RUN addgroup -g 101 -S nginx && adduser -u 101 -S -D -G nginx nginx
