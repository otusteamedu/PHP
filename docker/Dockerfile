FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
	libicu-dev \
	libzip-dev \
	libcurl4-openssl-dev \
	libssl-dev \
	unzip

RUN docker-php-ext-install \
            intl \
            zip \
            pcntl \
            sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
