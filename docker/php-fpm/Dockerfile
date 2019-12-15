FROM php:7.4-fpm-alpine

RUN sed -i 's/listen = 9000/listen = \/socket\/php-fpm.sock\nlisten.mode = 0666/' /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /app