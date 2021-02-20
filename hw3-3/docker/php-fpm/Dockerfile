FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    grep \
    libmemcached-dev \
    zlib1g-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libssl-dev \
    libpq-dev \
    && pecl install -of redis && docker-php-ext-enable redis \
    && pecl install -of memcached && docker-php-ext-enable memcached \
    && pecl install -of raphf propro && docker-php-ext-enable raphf propro \
    && pecl install -of pecl_http-3.2.4 && docker-php-ext-enable http \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app