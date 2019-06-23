    # Для начала указываем исходный образ, он будет использован как основа
FROM php:7.1-fpm
# Необязательная строка с указанием автора образа
MAINTAINER Vlad Zaiko <vl.zayko@gmail.com>

RUN apt-get update && apt-get install -y \
    unzip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Install PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        vim \
        curl \
        wget \
        grep \
        mc \
    && docker-php-ext-install -j$(nproc) iconv bcmath iconv mcrypt mbstring  \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get install -y zlib1g-dev libicu-dev g++ libzip-dev && \
    docker-php-ext-configure intl && \
    docker-php-ext-install intl zip sockets && \
    apt-get purge -y g++

RUN apt-get install -y libxslt-dev
RUN docker-php-ext-install xsl soap mysqli

# Install Redis extension
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/docker-php-ext-redis.ini

# Install MongoDB extension
RUN pecl install mongodb \
    && rm -rf /tmp/pear \
    && echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/docker-php-ext-mongodb.ini

# Install Memcached extension
RUN apt-get update && apt-get install -y libz-dev libmemcached-dev
RUN pecl install memcached
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini

# Install xdebug extensions
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

#pecl_http
RUN apt-get install -y zlib1g-dev libssl-dev libcurl4-openssl-dev
RUN pecl install -of raphf propro
RUN docker-php-ext-enable raphf propro
RUN pecl install -of pecl_http
RUN docker-php-ext-enable http

RUN chown -R www-data:www-data /var/www
RUN chmod 755 /var/www
