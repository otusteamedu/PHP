FROM php:7.4-fpm

RUN apt-get update && apt-get install -y curl git wget grep libz-dev libpq-dev libmemcached-dev libssl-dev libcurl4-openssl-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install -o propro && docker-php-ext-enable propro
RUN pecl install -o raphf && docker-php-ext-enable raphf
RUN pecl install -o pecl_http

EXPOSE 9100
CMD ["php-fpm"]
