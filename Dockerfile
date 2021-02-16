FROM php:8.0-cli

RUN apt update && apt install -y unzip nano curl wget git autoconf zlib1g-dev libmemcached-dev libcurl4-openssl-dev libpq-dev libevent-dev libicu-dev libssl-dev
RUN pecl install libcurl raphf redis memcached

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

RUN echo "extension=raphf" >> /usr/local/etc/php/conf.d/raphf.ini

RUN apt install -y
RUN pecl install pecl_http

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /app/
