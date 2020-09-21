FROM php:7.4-fpm-alpine

RUN apk add git \
        wget \
        grep \
        $PHPIZE_DEPS \
        libmemcached-dev \
        postgresql-dev \
	zlib-dev \
	curl-dev \
    && pecl install -of redis \
    && pecl install -of memcached \
    && pecl install -of raphf \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable redis memcached raphf \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 
