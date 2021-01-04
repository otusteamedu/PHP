FROM php:7.4-fpm-alpine

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual \
        icu-dev \
        curl \
        wget \
        bash \
            gcc \
            libc-dev \
            make \
            pkgconfig \
            zlib-dev \
            libmemcached-dev \
            libcurl \
            curl-dev \
            libpq \
            postgresql-dev \
            $PHPIZE_DEPS \
    && pecl install -of  mongodb \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
          sockets \
    && docker-php-ext-enable mongodb

RUN mkdir mkdir /sock/ && \
    chown -Rf www-data:www-data /sock/ && \
    chmod +x /var/www/html/

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
