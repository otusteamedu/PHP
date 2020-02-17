FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN pecl install redis-5.1.1 \
    && docker-php-ext-enable redis

RUN apt-get install -y \
         git \
         curl \
         wget \
         grep

RUN apt-get install -y \
        libmemcached-dev \
    && pecl install memcached \
    && docker-php-ext-enable memcached

RUN apt-get install -y \
        libpq-dev \
        libzip-dev \
        libicu-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libmagickwand-6.q16-dev \
        libxslt-dev \
    && docker-php-ext-install pdo_pgsql

RUN git clone https://github.com/xdebug/xdebug.git \
    && cd xdebug* \
    && phpize \
    && ./configure --enable-xdebug \
    && make \
    && make install \
    && docker-php-ext-enable xdebug

RUN wget https://getcomposer.org/installer \
    && php installer \
    && mv composer.phar /usr/local/bin/composer
