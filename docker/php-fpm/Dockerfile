FROM php:7.3-fpm-alpine as php-fpm-base

RUN apk add postgresql-dev \
    && docker-php-ext-install pgsql pdo_pgsql \
    && docker-php-ext-enable pdo_pgsql \
    && mv /usr/local/etc/php/conf.d/docker-php-ext-pgsql.ini /usr/local/etc/php/conf.d/docker-php-ext-pgsql.ini-disabled

FROM php-fpm-base

USER www-data
