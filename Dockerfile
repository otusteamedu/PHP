FROM php:7.2-fpm

RUN apt-get update && \
    apt-get install -y \
        unzip \
        git \
        wget \
        libpq-dev \
        zlib1g \
        libzip-dev \
        libmemcached-dev \
        libcurl4-gnutls-dev \
        libgnutls28-dev \
        libssl-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo_pgsql zip && \
    pecl install redis memcached raphf propro && \
    docker-php-ext-enable redis memcached raphf propro && \
    pecl install pecl_http && \
    docker-php-ext-enable http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www

