FROM php:7.4-fpm-alpine

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
     && docker-php-ext-install sockets \
     && addgroup -g 101 -S nginx \
     && adduser -u 101 -D -S -G nginx nginx

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/
