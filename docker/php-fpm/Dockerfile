FROM php:7.4-fpm-alpine

RUN apk update \
    && apk add --no-cache git

# Redis через pecl
RUN apk update \
    && apk add --no-cache --virtual build-deps autoconf build-base \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del build-deps \
    && rm -rf /var/cache/apk/*

RUN pecl list > /1_redis_pecl_list.txt; \
    php -i | grep redis  > /1_redis_php_info.txt

# XDebug через make
ENV XDEBUG_VERSION 2.9.0
RUN set -eux; \
    apk update \
    && apk add --no-cache --virtual build-deps git $PHPIZE_DEPS \
#    && git clone git://github.com/xdebug/xdebug.git \
    && wget https://xdebug.org/files/xdebug-$XDEBUG_VERSION.tgz \
    && tar -xzf xdebug-$XDEBUG_VERSION.tgz \
    && cd xdebug-$XDEBUG_VERSION \
    && phpize \
    &&  ./configure \
    && make > /2_xdebug_make_output.txt \
    && make install \
    && make clean \
    && docker-php-ext-enable xdebug \
    && apk del build-deps \
    && cd .. && rm -rf xdebug-$XDEBUG_VERSION \
    && rm -rf /var/cache/apk/*

RUN php -i | grep xdebug  > /2_xdebug_php_info.txt

COPY zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin

RUN mkdir /app \
    && mkdir -p /var/www/.composer \
    && chown -R www-data:www-data /app /var/www

WORKDIR /app

RUN composer global require --optimize-autoloader hirak/prestissimo