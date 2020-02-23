FROM php:7.4-fpm

RUN apt-get update \
    && apt-get install -y \
    git \
    curl \
    wget \
    grep \
    gcc g++ make \
    && curl -sS https://getcomposer.org/installer \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && pecl install redis memcached pecl_http pdo_pgsql \
    && docker-php-ext-enable redis memcached pecl_http pdo_pgsql 
