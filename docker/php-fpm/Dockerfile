FROM php:7.3-fpm-alpine as php-fpm-base

RUN apk add --no-cache libpq libxml2 \
    && apk add --no-cache --virtual .build-deps libxml2-dev postgresql-dev \
    && docker-php-ext-install bcmath pdo_pgsql xml \
    && apk del --purge .build-deps

RUN pecl channel-update pecl.php.net \
    && apk add --no-cache --virtual .build-deps g++ make autoconf \
    && pecl install apcu-5.1.17 \
    && pecl install xdebug-2.7.2 \
    && docker-php-ext-enable apcu xdebug \
    && apk del --purge .build-deps \
    && pecl clear-cache

RUN mkdir --parents /usr/local/bin \
    && wget -qcO /usr/local/bin/composer -- https://github.com/composer/composer/releases/download/1.8.6/composer.phar \
    && chmod +x /usr/local/bin/composer

COPY . /var/www/

RUN chown -R www-data /var/www

FROM php-fpm-base

USER www-data

WORKDIR /var/www

RUN composer create-project --no-interaction --no-ansi --no-progress --prefer-dist laravel/laravel /var/www/laravel \
    && composer clear-cache --no-interaction --no-ansi
