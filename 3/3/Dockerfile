FROM php:7.4-cli

RUN apt-get update && apt-get install -y curl git wget grep libz-dev libpq-dev libmemcached-dev libssl-dev libcurl4-openssl-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install -o memcached && docker-php-ext-enable memcached
RUN pecl install -o redis && docker-php-ext-enable redis
RUN pecl install -o propro && docker-php-ext-enable propro
RUN pecl install -o raphf && docker-php-ext-enable raphf
RUN pecl install -o pecl_http
RUN docker-php-ext-install pdo_pgsql

WORKDIR /var/www/