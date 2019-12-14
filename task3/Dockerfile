FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
    git \
    wget \
    curl \
    zlib1g-dev \
    libmemcached-dev \
    libevent-dev \
    libicu-dev \
    libidn2-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    libz-dev \

RUN pecl install -of redis
RUN pecl install -of memcached

RUN pecl install -of raphf
RUN docker-php-ext-enable raphf
RUN pecl install -of propro
RUN docker-php-ext-enable propro
RUN pecl install -of pecl_http
RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-enable redis
RUN docker-php-ext-enable memcached
RUN docker-php-ext-enable http
#RUN docker-php-ext-enable pdo_pgsql
