FROM php:7.2-cli


RUN apt-get update && apt-get install -y -f software-properties-common apt-utils mc wget nano git grep curl unzip tar gnupg zlib1g-dev libmemcached-dev build-essential \
					    libcurl3 libpcre3-dev libcurl4-openssl-dev libpq-dev libssl-dev libssl-dev libpq5

RUN cd /tmp && curl -sS https://getcomposer.org/installer -o composer-setup.php && php composer-setup.php

#RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

RUN pecl install redis-4.0.1
RUN pecl install xdebug-2.6.0
RUN pecl install raphf
RUN echo "extension=raphf.so" >> $PHP_INI_DIR/conf.d/raphf.ini
RUN pecl install propro
RUN echo "extension=propro.so" >> $PHP_INI_DIR/conf.d/propro.ini
RUN pecl install pecl_http
RUN echo "extension=http.so" >> $PHP_INI_DIR/conf.d/pecl_http.ini
RUN pecl install memcached

RUN docker-php-ext-install pdo_pgsql

RUN rm /tmp/* -R -f
