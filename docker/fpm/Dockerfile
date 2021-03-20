FROM php:7.4-fpm

LABEL maintainer="Alexandr Timofeev <tim31al@gmail.com>"

RUN apt-get update && apt-get install -y \
	libpq-dev \
	libicu-dev \
	libzip-dev \
	libcurl4-openssl-dev \
	libssl-dev \
	libpng-dev \
	libmemcached-dev \
	unzip

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install intl \
            pdo_pgsql \
            zip \
            json \
            curl \
            gd \
            pcntl \
            sockets


RUN pecl install redis-5.3.3 && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && pecl install memcached-3.1.5 && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini\
    && pecl install raphf-2.0.1 && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install propro && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install pecl_http-3.2.4 && echo "extension=http.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install xdebug-3.0.2 && echo "zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
    && rm -fr /tmp/pear


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

ARG UID
ARG GID
ARG USER
ARG GROUP

RUN addgroup --system --gid ${GID} ${GROUP} \
 && adduser --system --no-create-home -uid ${UID} --gid ${GID} \
    --disabled-password --disabled-login ${GROUP}

RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

COPY php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
