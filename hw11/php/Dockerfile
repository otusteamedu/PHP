FROM php:7.2-fpm-alpine


RUN docker-php-ext-install sockets
RUN pecl bundle -d /usr/src/php/ext redis \
    && rm /usr/src/php/ext/redis-*.tgz \
    && docker-php-ext-install redis

RUN apk --no-cache add pcre-dev ${PHPIZE_DEPS} \
    && pecl install mongodb && docker-php-ext-enable mongodb

RUN addgroup -g 101 -S nginx && adduser -u 101 -S -D -G nginx nginx
