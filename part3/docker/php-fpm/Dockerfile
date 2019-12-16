FROM php:fpm-alpine

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /var/www/html

RUN apk update && apk add --no-cache --update autoconf \
    git \
    curl \
    wget \
    grep \
    bash \
    composer \
    libpq \
    g++ \
    gcc \
    make \
    libmemcached-dev \
    zlib-dev \
    curl-dev \
    icu-dev \
    postgresql-dev

RUN pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \
    && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable http

CMD ["php-fpm","--nodaemonize"]