FROM php:7.4-fpm-alpine
WORKDIR /var/www/mysite.local

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apk update && apk add php7-dev \
    gcc \
    g++ \
    make \
    libmemcached-dev \
    postgresql-dev \
    bash \
    zlib-dev \
    libpq \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx

EXPOSE 9000
CMD ["php-fpm"]