FROM php:7.4-cli

RUN apt-get update && apt-get install -y \
    git \
    wget \
    libpq-dev \
    libmemcached-dev \
    zlib1g-dev \
    libcurl4-openssl-dev \
    libssl-dev && \
    docker-php-ext-install pdo pdo_pgsql && \
    pecl install redis memcached && docker-php-ext-enable redis memcached && \
    pecl install raphf && docker-php-ext-enable raphf && \
    pecl install propro && docker-php-ext-enable propro && \
    pecl install pecl_http && docker-php-ext-enable http

COPY --from=composer:1 /usr/bin/composer /usr/bin/composer
