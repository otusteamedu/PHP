FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        curl \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
        && composer install