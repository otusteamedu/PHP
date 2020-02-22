FROM php:7.3-alpine

RUN apk update && \
    apk add git curl wget grep composer zstd-dev php7-dev gcc g++ make libmemcached-dev postgresql-dev curl-dev

RUN pecl install -of raphf && docker-php-ext-enable raphf && \
    pecl install -of propro && docker-php-ext-enable propro && \
    pecl install pecl_http && docker-php-ext-enable http && \
    pecl install -of igbinary && docker-php-ext-enable igbinary && \
    pecl install -of zstd && docker-php-ext-enable zstd && \
    pecl install -of redis docker-php-ext-enable redis && \
    pecl install -of msgpack docker-php-ext-enable msgpack && \
    pecl install -of memcached docker-php-ext-enable memcached

RUN docker-php-ext-install pdo_pgsql

COPY ./src /var/www/html/

WORKDIR /var/www/html

EXPOSE 80:80