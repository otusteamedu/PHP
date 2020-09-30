FROM php:7.4-fpm
RUN apt-get update \
    && apt-get install -y git \
    curl \
    unzip \
    wget \
    zlib1g-dev \
    libmemcached-dev  \
    libmemcached11 \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libpq-dev \
    apt-file \
    && apt-get update \
    && apt-get install -y vim \
    && pecl install redis \
    && pecl install memcached \
    && pecl install raphf \
    && pecl install propro \
    && docker-php-ext-enable redis memcached raphf propro \
    && pecl install pecl_http \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && docker-php-ext-enable http pdo_pgsql \
    && curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && docker-php-ext-install \
    sockets

WORKDIR /www-data

COPY ./php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./php-fpm.sock /run/php/php-fpm.sock