FROM php:7.4-cli

#WORKDIR /var/www/otus-dev.ikm

ENV COMPOSER_ALLOW_SUPERUSER 1
ENV DEBIAN_FRONTEND=teletype


RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    apt-utils \
    git \
    curl \
    wget \
    grep \
    zip \
    libz-dev \
    libcurl4-nss-dev \
    libmemcached-dev \
    libpq-dev \
    && pecl install propro && docker-php-ext-enable propro \
    && pecl install raphf && docker-php-ext-enable raphf \
    && pecl install pecl_http && docker-php-ext-enable http \
    && pecl install redis && docker-php-ext-enable redis \
    && pecl install memcached && docker-php-ext-enable memcached \
    && docker-php-ext-install pdo \
    && docker-php-ext-configure pgsql \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/otus-dev.ikm
