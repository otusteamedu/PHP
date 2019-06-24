FROM php:7-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        grep \
        zip \
        unzip \
        zlib1g-dev \
        libmemcached-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        libpq-dev \
        libzip-dev

RUN docker-php-ext-install pdo_pgsql

RUN pecl install redis && docker-php-ext-enable redis
RUN pecl install memcached && docker-php-ext-enable memcached
RUN pecl install raphf && docker-php-ext-enable raphf
RUN pecl install propro && docker-php-ext-enable propro
RUN pecl install pecl_http && docker-php-ext-enable http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

CMD ["php-fpm"]