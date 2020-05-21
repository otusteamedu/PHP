FROM php:7.3.18-fpm-alpine

RUN apk update \
    && apk add --no-cache git \
        curl-dev \
        postgresql-dev \
        $PHPIZE_DEPS \
        zlib \
        libcurl \
        libevent \
        libidn \
        libidn2 \
        libmemcached \
        libmemcached-dev \
        icu-dev \
    && docker-php-ext-install pdo_pgsql \
    && pecl install -of raphf propro redis memcached \
    && docker-php-ext-enable raphf propro redis memcached \
    && pecl install -of pecl_http \
    && echo -e "extension=raphf.so\nextension=propro.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-raphf.ini \
    && rm -rf /usr/local/etc/php/conf.d/docker-php-ext-propro.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]