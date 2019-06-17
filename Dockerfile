FROM php:7-fpm

#main utils
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        grep \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev libcurl4-openssl-dev libssl-dev \
        libpq-dev libzip-dev        

#pecl
RUN pecl install raphf \
    && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini
RUN pecl install propro \
    && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini
RUN pecl install pecl_http \
    && echo "extension=http.so" >> /usr/local/etc/php/conf.d/http.ini
RUN pecl install redis \
    && echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini
RUN pecl install memcached \
    && echo "extension=memcached.so" >> /usr/local/etc/php/conf.d/memcached.ini
RUN pecl install mcrypt-1.0.2 \
    && echo "extension=mcrypt.so" >> /usr/local/etc/php/conf.d/mcrypt.ini

RUN docker-php-ext-install -j$(nproc) pdo_pgsql pdo_mysql
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ 
RUN docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /apps

CMD ["php-fpm"]

