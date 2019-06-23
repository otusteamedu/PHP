FROM php:7.3-fpm-alpine as php-fpm-base

RUN apk add --no-cache --virtual .build-deps postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del --purge .build-deps

RUN mkdir /tmp/apcu \
    && wget -qcO /tmp/apcu.tar.gz https://github.com/krakjoe/apcu/archive/v5.1.17.tar.gz \
    && tar -xf /tmp/apcu.tar.gz -C /tmp/apcu --strip-components=1 \
    && docker-php-ext-configure /tmp/apcu \
    && docker-php-ext-install /tmp/apcu \
    && rm -rf /tmp/apcu

RUN apk add --no-cache --virtual .build-deps g++ make autoconf \
    && pecl channel-update pecl.php.net \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && pecl clear-cache \
    && apk del --purge .build-deps

FROM php-fpm-base

USER www-data
