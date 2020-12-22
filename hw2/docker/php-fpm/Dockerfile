FROM php:7.4-fpm

RUN apt-get update && apt-get install libpng-dev libzip libzip-dev curl-dev && apt-get install autoconf g++ make zip gd zip curl git

RUN pecl install redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN pecl install propro && docker-php-ext-enable propro \
    && pecl install raphf && docker-php-ext-enable raphf \
    && pecl install pecl_http \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable http

RUN apt-get update && apt-get install libmemcached-dev && pecl install memcached \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable memcached

RUN apt-get install postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql gd zip json curl bcmath

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

#install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && composer global require hirak/prestissimo --no-plugins --no-scripts \
    && rm -rf /root/.composer/cache

WORKDIR /var/www/html

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]