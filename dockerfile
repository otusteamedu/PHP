FROM php:7.4-fpm-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        libmemcached \
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
        libpng \
        libpng-dev \
        libjpeg \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype \
        freetype-dev \
        curl \
        wget \
        grep \
        bash

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
    intl \
    gd \
    pcntl \
    sockets \
    zip
RUN pecl channel-update pecl.php.net \
    && pecl install -o -f \
        redis \
        event \
        xdebug \
        memcached \
        pecl_http \
        pdo_pgsql \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "extension=event.so" > /usr/local/etc/php/conf.d/event.ini \
    && docker-php-ext-enable memcached pecl_http pdo_pgsql
