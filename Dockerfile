FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y \
	curl \
	wget \
	git \
	grep \
    zlib1g-dev \
    libmemcached-dev \
    libpq-dev \
	libz-dev \
	libcurl4-nss-dev \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 
    # && pecl install -of redis memcached raphf propro pecl_http \
    # && docker-php-ext-enable redis memcached raphf propro http \
    # && docker-php-ext-install pdo_pgsql

RUN pecl install -of redis \
	&& docker-php-ext-enable redis 
RUN pecl install -of memcached \
    && docker-php-ext-enable memcached
RUN pecl install -of raphf propro \
    && docker-php-ext-enable raphf propro
RUN pecl install -of pecl_http \
    && docker-php-ext-enable http
RUN docker-php-ext-install pdo_pgsql

WORKDIR /var/www

EXPOSE 80:80 