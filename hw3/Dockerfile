FROM php:7.3-fpm-alpine

RUN apk add git \
        curl-dev \
        wget \
        grep \
        $PHPIZE_DEPS \
        zlib-dev \
        libmemcached-dev \
        postgresql-dev \
        icu-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install -of redis \
    && pecl install -of memcached \
    && pecl install -of raphf \
    && pecl install -of propro \
    && docker-php-ext-enable raphf propro \
    && pecl install -of pecl_http \
    # deprecated package pdo_pgsql in pecl
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable --ini-name docker-php-ext-z1-http.ini http \
    && docker-php-ext-enable redis memcached