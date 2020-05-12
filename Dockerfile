FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        apt-utils \
        git \
        wget \
        grep \
        curl \
        zlib1g-dev \
        libmemcached-dev \
        libssl-dev \
        libcurl4-openssl-dev \
        postgresql \
        libpq-dev \
    && pecl install -o redis-5.2.1 \
    && pecl install -o memcached-3.1.5 \
    && pecl install -o raphf \
    && pecl install -o propro \
    && docker-php-ext-enable raphf propro \
    && pecl install -o pecl_http-3.2.3 \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql \
    && docker-php-ext-enable \
        redis \
        memcached \
        http
