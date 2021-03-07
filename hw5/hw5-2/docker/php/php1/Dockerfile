FROM php:7.4-fpm-alpine

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
        libpng \
        libpng-dev \
        libjpeg \
        libjpeg-turbo-dev \
        libwebp-dev \
        freetype \
        freetype-dev \
        curl \
        wget \
        bash


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
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "extension=event.so" > /usr/local/etc/php/conf.d/event.ini

COPY zz-docker.conf /usr/local/etc/php-fpm.d/www.conf

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html

VOLUME /var/www/html

VOLUME /tmp/php1.sock

CMD ["php-fpm"]