FROM php:7.1-fpm

# all utils
RUN apt-get update && \
    apt-get -y install grep curl wget nano git libmemcached-dev zlib1g-dev libcurl4-openssl-dev libssl-dev

# composer
RUN cd /tmp && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin && \
    rm composer-setup.php

# pecl utils
RUN pecl install -of raphf
RUN echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini
RUN pecl install propro
RUN echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini
RUN pecl install pecl_http
RUN echo "extension=pecl_http.so" >> /usr/local/etc/php/conf.d/pecl_http.ini

RUN pecl install -of memcached
RUN echo "extension=memcached.so" >> /usr/local/etc/php/conf.d/memcached.ini

RUN pecl install -of redis
RUN echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini