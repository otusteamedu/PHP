FROM php:7.4.6-fpm
WORKDIR /var/www/hw.local

COPY php.ini /usr/local/etc/php

RUN apt-get update && apt-get install -y \
		git \
		curl \
		wget \
		grep \
		make \
		libmemcached-dev \
		zlib1g-dev \
		libcurl4-gnutls-dev \
		libgnutls28-dev \
		libpq-dev \
		&& pecl install raphf-2.0.1 \
		&& docker-php-ext-enable raphf \
		&& pecl install propro-2.1.0 \
		&& docker-php-ext-enable propro \
		&& pecl install pecl_http-3.2.3 \
		&& pecl install redis-5.2.2 \
		&& docker-php-ext-enable redis \
		&& pecl install memcached-3.1.5 \
		&& docker-php-ext-enable memcached \
		&& pecl install xdebug-2.9.6 \
		&& docker-php-ext-enable xdebug \
		&& docker-php-ext-install pdo \
		&& docker-php-ext-install pdo_pgsql \
		&& docker-php-ext-install iconv \
		&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
		&& echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
        && echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini \
        && echo "extension=raphf.so\nextension=propro.so\nextension=iconv.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini \
           && echo "extension=http.so" > /usr/local/etc/php/conf.d/http.ini

WORKDIR /data
VOLUME /data
CMD ["php-fpm"]
