FROM php:7.4.6-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update && apt-get install -y \
    git curl wget grep libmemcached-dev zlib1g-dev libcurl4-gnutls-dev libgnutls28-dev libpq-dev libpng-dev libzip-dev libonig-dev autoconf g++ make zip unzip curl exif \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

VOLUME /var/www/html

EXPOSE 9000

CMD ["php-fpm"]