FROM php:7.4-fpm-alpine

MAINTAINER evrimedont@gmail.com

ARG TIME_ZONE="Europe/Moscow"

RUN apk update \
    && apk add --no-cache git curl tzdata libpq icu libmemcached \
    && ln -f -s /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime \
    && echo ${TIME_ZONE} > /etc/timezone \
    && apk add --no-cache --virtual build-deps $PHPIZE_DEPS build-base postgresql-client postgresql-dev zlib-dev curl-dev icu-dev libmemcached-dev \

### POSTGRESQL ###
    && docker-php-ext-configure pdo_pgsql \
    && docker-php-ext-configure pgsql \
    && docker-php-ext-install -j$(nproc) pdo_pgsql pgsql \

### REDIS ###
    && pecl install redis \
    && docker-php-ext-enable redis \

### MEMCACHED ###
    && pecl install memcached \
    && docker-php-ext-enable memcached \

### PECL HTTP ###
    && pecl install raphf \
    && docker-php-ext-enable raphf \
    && pecl install propro \
    && docker-php-ext-enable propro \
    && pecl install pecl_http \
    && docker-php-ext-enable http \
    && mv /usr/local/etc/php/conf.d/docker-php-ext-http.ini /usr/local/etc/php/conf.d/zzz-docker-php-ext-http.ini \

### Cleaning ###
    && apk del build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* $HOME/.cache \
    && docker-php-source delete

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin

RUN mkdir /app \
    && mkdir -p /var/www/.composer \
    && chown -R www-data:www-data /app /var/www

WORKDIR /app

USER www-data

RUN composer global require --optimize-autoloader hirak/prestissimo