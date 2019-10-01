FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        libpq-dev \
        libzip-dev \
        git \
        curl \
        wget \
        grep \
        nano \
        htop \
    && printf "\n" | pecl install raphf propro zip\
    && docker-php-ext-enable raphf propro zip\
    && printf "\n" | pecl install pecl_http \
    && docker-php-ext-install sockets bcmath iconv gd \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/

RUN cd /var/www/html && composer create-project --prefer-dist laravel/laravel blog "5.8.*"

