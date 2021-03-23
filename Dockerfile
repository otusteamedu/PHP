FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    grep \
    zip \
    unzip \
    libmemcached-dev \
    libonig-dev \
    libpq-dev \
    zlib1g-dev \
    libzip-dev \
    vim \
    && apt-get clean \
    && rm -r /var/lib/apt/lists/* \
    && pecl install redis memcached raphf pecl_http xdebug-2.8.0 \
    && docker-php-ext-enable redis memcached raphf xdebug \
    && docker-php-ext-install json \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install mbstring

#установка composer
RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

WORKDIR /var/www