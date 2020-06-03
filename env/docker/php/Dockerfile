FROM php:7.4-fpm-alpine

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual \
        icu-dev \
        curl \
        wget \
        bash \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
          sockets
