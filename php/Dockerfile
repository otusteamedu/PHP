FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
    git

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www

COPY ./composer.json /var/www/composer.json

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --prefer-source --no-interaction

CMD ["php-fpm"]