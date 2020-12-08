FROM php:7.4-fpm

RUN apt update && apt install -y git nano curl wget libpq-dev zlib1g-dev libmemcached-dev libcurl4-openssl-dev libssl-dev \
    && pecl install redis memcached propro raphf \
    && docker-php-ext-enable redis memcached propro raphf \
    && docker-php-ext-install pdo_pgsql \
    && pecl install pecl_http \
    && echo "extension=http" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN ["php-fpm", "-D"]