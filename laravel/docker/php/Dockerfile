FROM php:7.3-fpm-alpine

ARG UID
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

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

WORKDIR /data

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer create-project --prefer-dist laravel/laravel blog "5.8.*" \
    && addgroup -g $UID -S app \
    && adduser -u $UID -S -D -G app app \
    && chown -Rf app:app /data/blog \
    && chmod 777 -R blog/storage