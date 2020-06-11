FROM php:7.4.0-fpm

RUN apt-get update && apt-get install -y wget git unzip libc6 libfreetype6 libgd-dev libpng-dev \
    && docker-php-ext-install pdo_mysql gd exif  

ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www
