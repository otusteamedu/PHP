FROM php:7.4-fpm-alpine

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
    libzip-dev \
    oniguruma-dev \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && docker-php-ext-install sockets \
    && pecl install -of pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install bcmath \
    && docker-php-ext-enable bcmath \
    && docker-php-ext-install ctype \
    && docker-php-ext-enable ctype \
    && docker-php-ext-install json \
    && docker-php-ext-enable json \
    && docker-php-ext-install zip \
    && docker-php-ext-enable zip \
    && docker-php-ext-install mbstring \
    && docker-php-ext-enable mbstring \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx

CMD ["php-fpm"]