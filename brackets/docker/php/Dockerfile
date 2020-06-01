FROM php:7.3-fpm-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        libevent-dev \
        openssl-dev \
        zlib-dev \
        libzip \
        libzip-dev \
        zlib \
        zlib-dev \
        bzip2 \
        git \
        curl \
        wget \
        bash

# Install PHP extensions
RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
    mbstring \
    sockets \
    zip

ARG UID
RUN addgroup -g $UID -S app \
  && adduser -u $UID -S -D -G app app

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf