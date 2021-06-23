FROM php:7.4-fpm

RUN docker-php-ext-install sockets

COPY php.ini /usr/local/etc/php/conf.d/php.ini
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /app