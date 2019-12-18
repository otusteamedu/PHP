FROM php:7.4.0-fpm-alpine

RUN apk update && apk add --no-cache \
	$PHPIZE_DEPS \
	grep \
	git \
	curl-dev \
	wget \
	zlib-dev \
	libmemcached-dev \ 
	autoconf \
    	cyrus-sasl-dev

RUN pecl install redis-5.1.1 \
    && pecl install xdebug-2.8.1 \
    && pecl install memcached-3.1.5 \
    && pecl install raphf \
    && pecl install propro \
    && docker-php-ext-enable redis xdebug memcached raphf propro \
    && pecl install pecl_http \
    && docker-php-ext-enable http

RUN addgroup -g 1000 -S ruben
RUN adduser -u 1000 -S -G ruben ruben
 
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
 
USER ruben
 
CMD ["php-fpm", "--nodaemonize"]
