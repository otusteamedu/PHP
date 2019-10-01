FROM php:7.2-fpm-alpine
RUN apk add php7-dev gcc g++ make && \
    apk add git && \
    apk add curl && \
    apk add wget && \
    apk add grep && \
    apk add libmemcached-dev &&\
    pecl install -of memcached && \
    docker-php-ext-enable memcached && \
    pecl install -of redis && \
    docker-php-ext-enable redis && \
    pecl install -of pdo_pgsql && \
    docker-php-ext-enable pdo_pgsql && \
    pecl install -of pecl_http && \
    docker-php-ext-enable pecl_http && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
