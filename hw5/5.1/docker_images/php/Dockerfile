FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    && docker-php-ext-install -j$(nproc) zip mbstring intl \
    && docker-php-ext-configure intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www

CMD ["php-fpm"]
