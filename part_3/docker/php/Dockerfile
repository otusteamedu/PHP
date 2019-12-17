FROM php:7.4.0-fpm-alpine

RUN apt-get update && apt-get install -y \
        grep \
	git \
	curl \
	wget \
	composer \

RUN pecl install redis-5.1.1 \
    && pecl install xdebug-2.8.1 \
    && pecl install memcached \
    && pecl install pecl_http \
    && pecl install pdo \
    && pecl install pdo_pgsql \
    && docker-php-ext-enable redis xdebug memcached pecl_http pdo pdo_pgsql

RUN addgroup -g 1000 -S ruben
RUN adduser -u 1000 -S -G ruben ruben
 
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf
 
USER ruben
 
CMD ["php-fpm", "--nodaemonize"]
