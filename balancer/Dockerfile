FROM php:7.4-fpm
RUN apt-get update && apt-get install -y git wget grep curl zlib1g-dev libmemcached-dev libpq-dev libssl-dev libcurl4-openssl-dev \
    && pecl install propro-2.0.0 \
    && pecl install raphf-2.0.1 \
    && docker-php-ext-enable propro raphf\
    && pecl install redis-5.1.1 \
    && pecl install memcached-3.1.4 \
    && pecl install pecl_http-3.2.3 \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable redis memcached http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer