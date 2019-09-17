FROM php:7.3-fpm-alpine

RUN apk add --no-cache php7-dev gcc g++ make libmemcached-dev curl-dev libpq postgresql-dev icu-dev git curl && \
    pecl install -of propro raphf && \
    echo "extension=propro.so" >> /usr/local/etc/php/conf.d/http.ini && \
    echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/http.ini && \
    pecl install -of pecl_http && \
    echo "extension=http.so" >> /usr/local/etc/php/conf.d/http.ini && \
    docker-php-ext-install pdo_pgsql && \
    pecl install -of redis memcached && \
    docker-php-ext-enable redis memcached && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
