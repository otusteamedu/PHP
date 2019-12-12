FROM php:7.3-fpm-alpine
WORKDIR /home/www/mysite.local
ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev

COPY ./install-composer.sh /
COPY ./php.ini /usr/local/etc/php/
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

RUN apk add --no-cache \
        bash \
        wget \
        git \
		$PHPIZE_DEPS \
		$MEMCACHED_DEPS \
		openssl-dev

RUN pecl install -of \
        xdebug \
        redis \
##        pecl_http \
##        pdo_pgsql \
        memcached

RUN docker-php-ext-enable \
        xdebug \
        redis \
##        pecl_http \
##        pdo_pgsql \
        memcached

RUN docker-php-ext-install sockets

RUN set -x \
	&& addgroup -g 101 -S nginx \
	&& adduser -u 101 -D -S -G nginx nginx \
    && sh /install-composer.sh \
    && rm /install-composer.sh \
    && rm -rf /tmp/*

EXPOSE 9000
CMD ["php-fpm"]