FROM php:7.3-fpm-alpine as stage-build

RUN pecl channel-update pecl.php.net \
    && apk add --no-cache icu-libs \
    && apk add --no-cache --virtual .build-deps g++ make autoconf icu-dev \
    && docker-php-ext-install intl \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug \
    && apk del --purge .build-deps \
    && pecl clear-cache

FROM composer:1.8.6 as stage-compose

COPY . /app

RUN composer install --no-dev --working-dir=/app --no-interaction --no-progress --no-suggest --no-ansi

FROM stage-build

COPY --from=stage-compose --chown=www-data /app/ /var/www/

USER www-data

WORKDIR /var/www
