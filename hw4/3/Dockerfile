FROM php:fpm-alpine  
# utils ... 
RUN apk add --no-cache bash git wget curl grep sed 
# composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --quiet --install-dir=/usr/local/bin/ --filename=composer \
    && composer --version
# deps & pecl prepare 
RUN apk add --no-cache postgresql-dev libmemcached-dev zlib-dev curl-dev icu-dev 
RUN pecl channel-update pecl.php.net 
# php extetions 
RUN apk add --no-cache --virtual .deps gcc g++ autoconf make \
    && docker-php-ext-install -j$(nproc) pdo_pgsql \
    && pecl install -of igbinary-3.0.0 msgpack-2.0.3 redis-4.2.0 memcached-3.1.3   \
    && docker-php-ext-enable igbinary msgpack redis memcached \
    && ( \
    pecl install -of raphf-2.0.0 propro-2.1.0  \
    && echo extension=raphf.so >> /usr/local/etc/php/conf.d/http.ini \
    && echo extension=propro.so >> /usr/local/etc/php/conf.d/http.ini \
    && pecl install -of pecl_http-3.2.0 \
    && echo extension=http.so >> /usr/local/etc/php/conf.d/http.ini \
    ) \
    && apk del .deps 
