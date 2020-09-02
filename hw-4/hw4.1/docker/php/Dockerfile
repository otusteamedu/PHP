FROM php:7.4-fpm-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        libmemcached-dev\
        openssl-dev \
        git \
        freetype \
        freetype-dev \
        postgresql-dev \
        curl-dev \
        curl \
        wget \
        bash \
        nano \
        grep \
        libpq

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

WORKDIR /var/www/html
COPY docker-entrypoint.sh /var/www/html/docker-entrypoint.sh

# Install PHP extensions
RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
    pdo \
    pdo_pgsql \
    pgsql

RUN pecl channel-update pecl.php.net \
    && pecl install -of \
        redis \
        memcached \
        raphf \
        propro

RUN echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini

RUN docker-php-ext-enable raphf propro
RUN pecl install -of pecl_http
RUN echo "extension=raphf.so\nextension=propro.so\nextension=iconv.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini \
    && echo "extension=http.so" > /usr/local/etc/php/conf.d/http.ini

ENTRYPOINT ["/usr/bin/docker-entrypoint.sh"]
