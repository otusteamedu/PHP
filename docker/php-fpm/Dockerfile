FROM php:7.3-fpm

RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
EXPOSE 9000