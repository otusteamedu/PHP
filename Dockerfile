FROM php:7.3-fpm as php

RUN apt update && apt install -y \
    git \
    unzip \
    libz-dev \
    libmemcached-dev \
    libcurl4-openssl-dev \
    libc6 \
    libpq-dev \
    libssl-dev \
    --no-install-recommends \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install memcached && docker-php-ext-enable memcached \
    && pecl install raphf && docker-php-ext-enable raphf \
    && pecl install propro && docker-php-ext-enable propro \
    && pecl install pecl_http && docker-php-ext-enable http \
    && docker-php-ext-install -j$(nproc) pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app/src
COPY . ./

CMD ["php-fpm"]

