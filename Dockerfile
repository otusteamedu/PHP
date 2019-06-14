FROM php:7.1-fpm

# UTILS
RUN apt-get update && \
    apt-get -y install grep curl wget nano git

#COMPOSER
RUN cd /tmp && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin && \
    rm composer-setup.php

# MEMCACHED with dependencies
RUN apt-get install -y libmemcached-dev zlib1g-dev
RUN pecl install -of memcached
RUN echo "extension=memcached.so" >> /usr/local/etc/php/conf.d/memcached.ini

# REDIS
RUN pecl install -of redis
RUN echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini


# PECL_HTTP with dependencies
RUN pecl install raphf
RUN echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini
RUN pecl install propro
RUN echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini
RUN apt-get install -y libcurl4-openssl-dev libssl-dev
RUN pecl install pecl_http
RUN echo "extension=http.so" >> /usr/local/etc/php/conf.d/pecl_http.ini

COPY "./src" "/app"
