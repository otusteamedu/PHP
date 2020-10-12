FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    docker-php-ext-install pdo pdo_pgsql pdo_mysql pdo_sqlite

COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
