FROM php:7.2-fpm

MAINTAINER Aleksey Zarikhin <a.zarikhin@yandex.ru>

RUN apt-get update \
    && apt-get install -y -qq git \
    && apt-get install -y -qq wget \
    && apt-get install -y -qq curl \
    && apt-get install -y -qq zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql

WORKDIR /var/www

CMD ["php-fpm"]
