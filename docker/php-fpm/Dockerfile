FROM php:7.4.0-fpm

RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug-2.9.5 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql 

ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www
