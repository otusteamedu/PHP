FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        libssl-dev \
        libicu-dev \
        libpcre3-dev \
        zlib1g-dev \
        libz-dev \
        libxml2-dev \
        libzip-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) zip intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD ["php-fpm"]
