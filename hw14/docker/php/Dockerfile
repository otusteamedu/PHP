FROM php:7.3-cli-alpine

RUN apk update && apk add --no-cache gcc \
    make \
    autoconf \
    g++ \
    openssl-dev \
    curl \
    unzip \
    libzip-dev \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["/bin/sh"]