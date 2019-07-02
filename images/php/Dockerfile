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
        libzip-dev \
        && docker-php-ext-install -j$(nproc) iconv mbstring pdo pdo_pgsql zip sockets

RUN pecl install redis && docker-php-ext-enable redis \
    && pecl install memcached && docker-php-ext-enable memcached \
    && pecl install raphf && docker-php-ext-enable raphf \
    && pecl install propro && docker-php-ext-enable propro \
    && pecl install pecl_http && docker-php-ext-enable http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

WORKDIR /var/www

CMD ["php-fpm"]