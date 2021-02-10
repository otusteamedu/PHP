FROM php:7.4-fpm-alpine

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        libevent-dev \
        zlib-dev \
        libzip \
        libzip-dev \
        zlib \
        zlib-dev \
        libpng \
        libpng-dev \
        libjpeg \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype \
        freetype-dev \
        openssl-dev \
        libmemcached \
        libmemcached-dev \
        libcurl \
        curl-dev \
        postgresql-dev \
        bzip2 \
        git \
        curl \
        wget \
        grep

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install intl \
            pdo_pgsql \
            zip \
            json \
            curl \
            gd \
            pcntl \
            sockets


RUN pecl install redis-5.3.3 && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && pecl install memcached-3.1.5 && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini\
    && pecl install raphf-2.0.1 && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install propro && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install pecl_http-3.2.4 && echo "extension=http.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install xdebug-3.0.2 && echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && rm -fr /tmp/pear


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
