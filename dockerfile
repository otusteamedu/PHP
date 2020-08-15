FROM php:7.4-fpm-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add \
        libmemcached-dev \
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
        curl-dev \
        postgresql-dev \
        bash

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Install PHP extensions
RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
         intl \
         gd \
         pcntl \
         sockets \
         pdo_pgsql \
         zip

RUN pecl channel-update pecl.php.net \
    && pecl install -o -f \
        raphf \
        propro \
    && echo "extension=raphf.so" > /usr/local/etc/php/conf.d/http.ini \
    && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini \
    && pecl install -o -f \
        redis \
        event \
        xdebug \
        memcached \
        pecl_http-3.2.2 \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "extension=event.so" > /usr/local/etc/php/conf.d/event.ini \
    && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini \
#     && echo "extension=http.so" >> /usr/local/etc/php/conf.d/http.ini