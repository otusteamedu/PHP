FROM php:7-fpm

RUN apt-get update && apt-get install -y zip \
    jpegoptim optipng pngquant gifsicle \
    zlib1g-dev \
    libzip-dev \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

USER www