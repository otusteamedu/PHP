FROM php:7.4-fpm-alpine
WORKDIR /var/www/mysite.local

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apk update && apk add php7-dev \
    git \
    curl \
    wget \
    grep \
    composer \
    gcc \
    g++ \
    make \
    libmemcached-dev \
    postgresql-dev \
    curl-dev \
    bash \
    zlib-dev \
    libpq \
    icu-dev \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install sockets \
    && pecl install -of mongodb \
    && docker-php-ext-enable mongodb \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx

EXPOSE 9000
CMD ["php-fpm"]