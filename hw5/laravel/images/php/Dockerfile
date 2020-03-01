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
    && apk add zlib-dev \
    && apk add curl-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www

CMD ["php-fpm"]

RUN composer create-project --prefer-dist laravel/laravel mysite.local