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
COPY docker-entrypoint.sh /usr/bin/docker-entrypoint.sh
RUN chmod +x /usr/bin/docker-entrypoint.sh

# Install PHP extensions
RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
    pdo \
    pdo_pgsql \
    pgsql

ENTRYPOINT ["/usr/bin/docker-entrypoint.sh"]
