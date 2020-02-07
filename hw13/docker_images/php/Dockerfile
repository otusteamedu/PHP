FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libssl-dev \
        libicu-dev \
        libpcre3-dev \
        zlib1g-dev \
        libz-dev \
        libzip-dev \
        autoconf \
        pkg-config \
        libcurl4-openssl-dev \
        libpq-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install mongodb \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) zip intl pdo pdo_pgsql \
    && docker-php-ext-enable mongodb

WORKDIR /var/www

CMD ["php-fpm"]
