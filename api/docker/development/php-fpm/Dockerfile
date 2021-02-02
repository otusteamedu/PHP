FROM php:8.0-fpm-alpine

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini
COPY ./conf.d /usr/local/etc/php/conf.d

WORKDIR /app/
