FROM php:7.4-fpm

RUN apt-get update && apt-get install -y curl zlib1g-dev libzip-dev libpng-dev libcurl4-openssl-dev libonig-dev \
    autoconf g++ make zip unzip git libpq-dev

RUN pecl install redis \
    && docker-php-ext-enable redis
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql gd zip json curl bcmath mbstring

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]