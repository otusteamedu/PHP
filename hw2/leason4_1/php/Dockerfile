FROM php:7.4-fpm-alpine

RUN apk update && apk add libpng-dev libzip libzip-dev curl-dev && apk add autoconf g++ make zip gd zip curl git

RUN pecl install xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug

RUN pecl install redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN pecl install propro && docker-php-ext-enable propro \
    && pecl install raphf && docker-php-ext-enable raphf \
    && pecl install pecl_http \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable http

RUN apk update && apk add libmemcached-dev && pecl install memcached \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable memcached

RUN set -ex \
    && apk add --no-cache --virtual .phpize-deps $PHPIZE_DEPS imagemagick-dev libtool \
    && export CFLAGS="$PHP_CFLAGS" CPPFLAGS="$PHP_CPPFLAGS" LDFLAGS="$PHP_LDFLAGS" \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && apk add --no-cache --virtual .imagick-runtime-deps imagemagick \
    && apk del .phpize-deps

RUN apk add postgresql-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql gd zip json curl bcmath

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

ENV COMPOSER_ALLOW_SUPERUSER 1

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && composer global require hirak/prestissimo --no-plugins --no-scripts \
    && rm -rf /root/.composer/cache

ADD ./php.ini /usr/local/etc/php/php.ini

WORKDIR /var/www