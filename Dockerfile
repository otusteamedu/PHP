FROM php:7.2-fpm
RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        libpq-dev \
        git \
        curl \
        wget \
        grep \
    && docker-php-ext-install pdo pdo_pgsql \
    && printf "\n" | pecl install raphf propro \
    && docker-php-ext-enable raphf propro \
    && printf "\n" | pecl install pecl_http \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    &&  pecl install redis-4.0.1 \
    &&  pecl install memcached-3.0.4 \
    && docker-php-ext-install -j$(nproc) iconv \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd