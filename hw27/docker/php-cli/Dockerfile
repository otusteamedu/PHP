FROM php:7.4-cli

RUN apt-get update && apt-get install -y libzip-dev libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install zip sockets pdo_pgsql

COPY php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /app