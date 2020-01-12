FROM php:7.4-cli-alpine

LABEL maintainer="evrimedont@gmail.com"

ARG UID
ARG GID

RUN echo $UID
RUN echo $GID

RUN apk add --no-cache --virtual build-deps shadow \
    && usermod -u $UID www-data \
    && groupmod -g $GID www-data \
    && docker-php-ext-install sockets \
    && apk del build-deps \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* $HOME/.cache \
    && docker-php-source delete

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