FROM php:7.4-fpm-alpine

#install dev dependecies
RUN apk update \
	&& apk upgrade --available \
	&& apk add --virtual build-deps \
		autoconf \
		build-base \
		icu-dev \
		libevent-dev \
		openssl-dev \
		zlib-dev \
		libzip \
		libzip-dev \
		zlib \
		zlib-dev \
		bzip2 \
		git \
		libpng \
		libpng-dev \
		libjpeg \
		libjpeg-turbo-dev \
		libwebp-dev \
		freetype \
		freetype-dev \
		postgresql-dev \
		curl \
		wget \
		bash
#install composer 
RUN curl -sS https://getcomposer.org/installer \
    | php -- --install-dir=/usr/bin --filename=composer --quiet


#install PHP-extensions
RUN docker-php-ext-configure gd --with-freetype=/usr/include --with-jpeg=/usr/include
RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
	intl \
	gd \
	bcmath \
	pdo_pgsql \
	pdo_mysql \
	sockets \
	zip
RUN pecl chanel-update pecl.php.net \
	&& pecl install -o -f \
		redis \
		event \
	&& rm -rf /tmp/pear \
	&& echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
        && echo "extension=event.so" > /usr/local/etc/php/conf.d/event.ini 

EXPOSE 9000

WORKDIR /www
