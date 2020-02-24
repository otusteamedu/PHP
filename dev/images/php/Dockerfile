FROM php:7.2-fpm-alpine

MAINTAINER Aleksey Zarikhin <a.zarikhin@yandex.ru>

RUN apk add php7-dev \
    && apk add gcc \
    && apk add g++ \
    && apk add make \
    && apk add git \
    && apk add curl \
    && apk add wget \
    && apk add grep \
    && apk add libmemcached-dev \
    && apk add zlib-dev \
    && apk add curl-dev \
    && apk add libpq \
    && apk add postgresql-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql

WORKDIR /var/www

CMD ["php-fpm"]