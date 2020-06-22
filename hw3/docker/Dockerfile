FROM php

WORKDIR /tmp

RUN apt-get update \
    && apt-get install -y \ 
    curl \
    git \
    grep \
    libcurl4-openssl-dev \
    libmemcached-dev \
    libpq-dev \
    libssh-dev \
    openssl \
    wget \
    zlib1g-dev \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && pecl install redis -of \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \ 
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && echo extension=http.so > /usr/local/etc/php/conf.d/http.ini \
    && docker-php-ext-install pdo pdo_pgsql