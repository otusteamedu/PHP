FROM php:7.3-fpm

RUN apt-get update

# Main packege
RUN apt-get install -y wget git unzip curl grep libpq-dev libz-dev libmemcached-dev

# Composer

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

# PGSQL_PDO
RUN docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql

# Xdebug
RUN pecl install xdebug-2.7.1 && docker-php-ext-enable xdebug

# Memcashed
RUN pecl install -of memcached \
    && docker-php-ext-enable memcached

# Redis
RUN pecl install -of redis \
        && docker-php-ext-enable redis

# Propro && raphf
RUN pecl install -of raphf propro \
    && docker-php-ext-enable raphf propro

RUN apt-get install -y zlib1g libzip-dev libcurl4-gnutls-dev libgnutls28-dev libssl-dev

# HTTP
RUN pecl install -of pecl_http \
    && docker-php-ext-enable http

WORKDIR /var/www/html
