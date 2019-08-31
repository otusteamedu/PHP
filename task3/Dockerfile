FROM php:7-fpm

LABEL maintainer="baldin@tutu.ru"

RUN apt-get update
RUN apt-get install -y \
	curl \
	wget \
	grep \
	git \
	libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libpng-dev \
    libmemcached-dev zlib1g-dev libcurl4-openssl-dev libssl-dev \
    libpq-dev libzip-dev

RUN pecl install raphf \
    && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini
RUN pecl install propro \
    && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini
RUN pecl install pecl_http
RUN pecl install redis
RUN pecl install memcached

RUN docker-php-ext-install pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]