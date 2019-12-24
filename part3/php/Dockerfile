FROM php:7-fpm
RUN addgroup --gid 3000 --system app && adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app

MAINTAINER Rudin Andrey <rudinandrey@yandex.ru>

RUN apt-get update && apt-get install -y git \ 
&& docker-php-ext-install pdo pdo_mysql \
&& apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd \
&& pecl install redis-5.1.1 \
&& pecl install xdebug-2.8.1
RUN apt-get install -y libcurl4-gnutls-dev \ 
	zlib1g-dev libicu-dev g++ libxml2-dev libpq-dev \
&& docker-php-ext-install curl json xml pdo_pgsql pgsql
RUN apt-get install -y libmemcached-dev zlib1g-dev \
&& pecl install memcached \
&& docker-php-ext-enable memcached redis xdebug


WORKDIR /app
