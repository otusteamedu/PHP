FROM php:7.4-fpm-alpine

ENV COMPOSER_ALLOW_SUPERUSER 1

ARG USER_ID
ARG GROUP_ID

RUN apk add --update --no-cache \
        git \
        wget \
        curl \
        grep \
        bash \
        shadow \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && rm -rf /tmp/* \
    && rm -rf /var/cache/apk/* \
    && usermod -u ${USER_ID} www-data \
    && groupmod -g ${GROUP_ID} www-data

WORKDIR /app



