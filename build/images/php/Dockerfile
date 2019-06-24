FROM php:7-fpm

#main utils
RUN apt-get update && apt-get install -y \
        procps \
        curl \
        wget \
        git \
        grep \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev libcurl4-openssl-dev libssl-dev \
        libpq-dev libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /apps

CMD ["php-fpm"]
