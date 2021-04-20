FROM php:7.4-cli

RUN apt-get update && apt-get install -y libzip-dev \
    && docker-php-ext-install zip \
    && pecl install redis \
    && docker-php-ext-enable redis

COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /app