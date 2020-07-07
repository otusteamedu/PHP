FROM php:7.4-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

ARG USER_ID
ARG GROUP_ID

RUN apk add --update --virtual .build-deps \
        autoconf \
        make \
        gcc \
        g++ \
        libtool \
        zlib-dev \
        curl-dev \
    && apk add --no-cache \
        git \
        wget \
        curl \
        grep \
        bash \
        shadow \
        icu-dev \
        postgresql-dev \
        libmemcached-dev \
    && pecl install \
        raphf \
        propro \
        xdebug \
        redis \
        memcached \
    && docker-php-ext-enable \
        raphf \
        propro \
        xdebug \
        redis \
        memcached \
    && docker-php-ext-configure \
        bcmath \
    && docker-php-ext-install \
        pdo_pgsql \
        bcmath \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/* \
    && rm -rf /var/cache/apk/* \
    && apk del .build-deps \
    && usermod -u ${USER_ID} www-data \
    && groupmod -g ${GROUP_ID} www-data

#USER "${USER_ID}:${GROUP_ID}"

WORKDIR /app



