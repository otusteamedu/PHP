FROM php:7.2-fpm-alpine
RUN apk update && apk upgrade && apk add \
        php7-dev gcc g++ make \
        git \
        curl-dev \
        wget \
        grep \
        libmemcached-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 
RUN pecl install -of redis && docker-php-ext-enable redis \
 && pecl install -of memcached && docker-php-ext-enable memcached \ 
 && pecl install -of raphf && docker-php-ext-enable raphf \
 && pecl install -of propro && docker-php-ext-enable propro \
 && pecl install -of pecl_http && docker-php-ext-enable pecl_http \
 && pecl install -of pdo_pgsql && docker-php-ext-enable pdo_pgsql
