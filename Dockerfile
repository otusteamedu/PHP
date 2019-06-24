FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libpq-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
    && docker-php-ext-install mbstring pdo pdo_pgsql

RUN pecl install redis-4.0.1 \
    && pecl install memcached-2.2.0 \
    && pecl install pecl_http \
    && docker-php-ext-enable redis memcached pecl_http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD ["php-fpm"]
