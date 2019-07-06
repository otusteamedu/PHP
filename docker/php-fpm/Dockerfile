FROM php:7.3-fpm-alpine as php-fpm-base

RUN mkdir --parents /usr/local/bin \
    && wget -qcO /usr/local/bin/composer -- https://github.com/composer/composer/releases/download/1.8.6/composer.phar \
    && chmod +x /usr/local/bin/composer

COPY . /var/www/

RUN chown -R www-data /var/www

FROM php-fpm-base

WORKDIR /var/www

USER www-data

RUN composer install --no-dev --no-interaction --no-progress \
    && composer clear-cache --no-interaction
