FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
        && apt-get install -y libpq-dev \
        && pecl install mongodb \
        && docker-php-ext-enable mongodb
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install exif
RUN docker-php-ext-install opcache
RUN docker-php-ext-install pcntl