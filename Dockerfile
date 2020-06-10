FROM php:fpm-alpine3.11

# Загружаем утилиты
RUN apk update && \
    apk add git  \
        curl  \
        grep  \
        wget  \
        openrc \
        g++ \
        gcc \
        autoconf \
        unzip \
        make \
        pkgconfig \
        zlib-dev \
        libmemcached libmemcached-dev \
        libsasl \ 
        php7-pdo_pgsql \ 
        php7-common \ 
        musl \
        libpq \
        postgresql-dev \
        libcurl \
        curl-dev


# устанавливаем redis
RUN pecl install redis && \
    docker-php-ext-enable redis

# устанавливаем memcached
RUN pecl install igbinary && \
    docker-php-ext-enable igbinary && \
    pecl install memcached && \
    docker-php-ext-enable memcached

# устанавливаем pecl_http
RUN pecl install propro && \
    docker-php-ext-enable propro && \
    pecl install raphf && \
    docker-php-ext-enable raphf && \
    pecl install pecl_http && \
    echo "extension=http.so" >> /etc/php7/php.ini

# устанавливаем pdo_pgsql
RUN docker-php-ext-install pdo_pgsql

RUN apk add --no-cache tini openrc busybox-initscripts

RUN apk add php-sockets && \
    docker-php-ext-install pcntl && \
    docker-php-ext-install sockets
        
RUN mkdir -p /var/spool/sockets 
    
 
# RUN rc-service crond start && rc-update add crond

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /usr/src/mysite.local

