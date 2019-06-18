FROM php:7.3-fpm

RUN apt-get update
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install -of mongodb
RUN docker-php-ext-enable mongodb

WORKDIR /app
EXPOSE 9000