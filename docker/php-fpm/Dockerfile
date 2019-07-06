FROM php:7.3-fpm-alpine as php-fpm-base

RUN apk add --no-cache libpq \
    && pecl channel-update pecl.php.net

RUN apk add --no-cache --virtual .build-deps postgresql-dev \
    && docker-php-ext-install pdo_pgsql \
    && apk del --purge .build-deps

RUN apk add --no-cache --virtual .build-deps g++ make autoconf \
    && pecl install apcu-5.1.17 \
    && docker-php-ext-enable apcu \
    && apk del --purge .build-deps

RUN apk add --no-cache --virtual .build-deps g++ make autoconf \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable xdebug \
    && apk del --purge .build-deps

RUN mkdir --parents /usr/local/bin \
    && wget -qcO /usr/local/bin/composer -- https://github.com/composer/composer/releases/download/1.8.6/composer.phar \
    && chmod +x /usr/local/bin/composer

COPY . /var/www/

RUN chown -R www-data /var/www

FROM php-fpm-base

USER www-data

WORKDIR /var/www

RUN composer install --no-dev --no-interaction --no-progress \
    && composer clear-cache --no-interaction
