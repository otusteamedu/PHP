FROM php:7.4-fpm

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    grep

RUN install-php-extensions \
    redis \
    memcached \
    pdo_pgsql \
    http

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp