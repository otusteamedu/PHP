FROM php:7-cli

RUN apt-get update && apt-get install -y \
    libzip-dev zip libpq-dev \
    && docker-php-ext-install zip sockets pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
