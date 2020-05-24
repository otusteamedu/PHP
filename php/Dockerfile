FROM php:7.3-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get update && ACCEPT_EULA=Y apt-get install -y --no-install-recommends \
    libxml2-dev \
    zip \
    unzip \
    && mkdir /var/www/laravel

RUN docker-php-ext-install \
    bcmath \
    pdo

WORKDIR /var/www/laravel