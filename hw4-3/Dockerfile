FROM php:7.1.27-cli

MAINTAINER timofey

# install required utilites
RUN apt update
RUN apt -y install git curl wget grep

# librares for pecl_http
RUN apt -y install zlib1g-dev libcurl4-openssl-dev libssl-dev

# library for pdo_pgsql
RUN apt -y install libpq-dev

# library for memcached
RUN apt -y install libmemcached-dev

# install dependences for pecl_http
RUN pecl install -f -o raphf
RUN echo 'extension=raphf.so' > /usr/local/etc/php/conf.d/pecl_http.ini
RUN pecl install -f -o propro
RUN echo 'extension=propro.so' >> /usr/local/etc/php/conf.d/pecl_http.ini

# install pecl_http module for php
RUN pecl install -f -o pecl_http
RUN echo 'extension=http.so' >> /usr/local/etc/php/conf.d/pecl_http.ini

# install pdo_pgsql module for php
RUN docker-php-ext-install pdo_pgsql

# install memcached module for php
RUN pecl install -o -f memcached
RUN docker-php-ext-enable memcached

# install redis module for php
RUN pecl install -o -f redis
RUN docker-php-ext-enable redis

# install composer
RUN mkdir /tmp/composer && cd /tmp/composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN cd ~ && rm -rf /tmp/composer
