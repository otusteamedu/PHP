FROM php:7.3-cli-alpine

RUN apk update && apk add --no-cache gcc \
    make \
    autoconf \
    g++ \
    openssl-dev \
    curl \
    unzip \
    libzip-dev

RUN pecl install redis

RUN docker-php-ext-install zip && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENTRYPOINT ["/bin/sh"]