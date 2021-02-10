## Build base image
FROM php:7.3-fpm-alpine as stage-build-base

RUN pecl channel-update pecl.php.net \
    && apk add --no-cache libpq \
    && apk add --no-cache --virtual .build-deps g++ make autoconf postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && pecl install apcu-5.1.17 \
    && docker-php-ext-enable apcu \
    && apk del --purge .build-deps \
    && pecl clear-cache


## Augment dev. image with xdebug et cetera
FROM stage-build-base as stage-build-dev

RUN pecl channel-update pecl.php.net \
    && apk add --no-cache --virtual .build-deps g++ make autoconf \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug \
    && apk del --purge .build-deps \
    && pecl clear-cache


## Compose project
FROM composer:1.8.6 as stage-compose

COPY . /app

# Add platform overrides here

RUN composer install --no-dev --working-dir=/app --no-interaction --no-progress --no-suggest --no-ansi


## Build production image
FROM stage-build-base as stage-production

COPY --from=stage-compose --chown=www-data /app/ /var/www/

USER www-data

WORKDIR /var/www


## Build development image
FROM stage-build-dev as stage-development

COPY --from=stage-compose --chown=www-data /app/ /var/www/

USER www-data

WORKDIR /var/www
