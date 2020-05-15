FROM composer:latest AS composer
FROM php:7.1-fpm

RUN apt-get update \
    && apt-get install -y bc \
        git \
        wget \
        zip\
        unzip\
        libpq-dev\
        libmemcached-dev \
        curl\
        libzip-dev\
        zlibc\
        zlib1g\
    && docker-php-ext-configure zip --with-libzip\
    && docker-php-ext-install zip\
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql\
    && pecl install xdebug && docker-php-ext-enable xdebug\
    && pecl install memcached && docker-php-ext-enable memcached\
    && pecl install redis && docker-php-ext-enable redis\
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
ADD ./www /var/www/html
EXPOSE 9000
