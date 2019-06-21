

FROM php:7.1-fpm

# git, curl, wget, grep..
RUN apt-get update && \
    apt-get -y install git curl wget grep vim libz-dev libmemcached-dev

# composer
RUN cd /tmp && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin && \
    rm composer-setup.php

#redis
RUN pecl install -of redis
RUN echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini

#memcached
RUN pecl install -of memcached
RUN echo "extension=memcached.so" >> /usr/local/etc/php/conf.d/memcached.ini

#pecl_http
RUN apt-get install -y zlib1g-dev libssl-dev libcurl4-openssl-dev
RUN pecl install -of raphf propro
RUN docker-php-ext-enable raphf propro
RUN pecl install -of pecl_http
RUN docker-php-ext-enable http

#pdo_pgsql
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

#Необходимо создать образ, который будет включать:
#- образ php, берем с https://hub.docker.com/_/php/
#- необходимые утилиты (git, curl, wget, grep...)
#- установленный composer
#- установленные расширения redis, memcached, pecl_http, pdo_pgsql
