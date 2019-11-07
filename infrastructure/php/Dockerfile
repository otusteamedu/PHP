FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    libzip-dev

RUN pecl install redis

RUN docker-php-ext-install zip && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer