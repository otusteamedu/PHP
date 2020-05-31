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

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
    mbstring \
    sockets \
    zip

ARG UID
RUN addgroup -g $UID -S app \
  && adduser -u $UID -S -D -G app app

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf


#RUN addgroup --gid $UID --system app \
#  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID app