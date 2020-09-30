FROM php:7.4-fpm-alpine

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

#COPY server.php /var/www/html/server.php
COPY entrypoint-server.sh /usr/bin/entrypoint-server.sh

RUN chmod +x /usr/bin/entrypoint-server.sh

WORKDIR /var/www/html

# Install PHP extensions
RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ENTRYPOINT ["/usr/bin/entrypoint-server.sh"]