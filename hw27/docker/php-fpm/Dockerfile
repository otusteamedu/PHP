FROM php:7.4-fpm

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install sockets pdo_pgsql

COPY php.ini /usr/local/etc/php/conf.d/php.ini
COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /app