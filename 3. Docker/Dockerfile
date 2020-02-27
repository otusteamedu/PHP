FROM php:7.2-fpm

# Main and Xdebug

RUN apt-get update && apt-get install -y wget git unzip curl grep libpq-dev libz-dev libmemcached-dev -y \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

# Composer

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

# pdo_pgsql

RUN	docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql

# Install Memcached for php 7

RUN curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
    && mkdir -p /usr/src/php/ext/memcached \
    && tar -C /usr/src/php/ext/memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
    && docker-php-ext-configure memcached \
    && docker-php-ext-install memcached \
    && rm /tmp/memcached.tar.gz

# Redis

RUN curl -L -o /tmp/redis.tar.gz https://github.com/phpredis/phpredis/archive/4.0.2.tar.gz \
    && tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext \
    && mv phpredis-* /usr/src/php/ext/redis

RUN docker-php-ext-install redis

WORKDIR /var/www
