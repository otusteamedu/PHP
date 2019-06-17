FROM php:7.3-fpm

RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql

WORKDIR /app
EXPOSE 9000