FROM php:7.3-cli-alpine

RUN apk update && \
    apk add git  \
        curl  \
        grep  \
        wget  \
        openrc \
        g++ \
        gcc \
        autoconf \
        unzip \
        make \
        pkgconfig \
        zlib-dev \
        libmemcached libmemcached-dev \
        libsasl \
        php7-pdo_pgsql \
        php7-common \
        musl \
        libpq \
        postgresql-dev \
        libcurl \
        curl-dev

#RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#RUN pecl install redis && \
#    docker-php-ext-enable redis

#RUN pecl install igbinary && \
#    docker-php-ext-enable igbinary && \
#    pecl install memcached && \
#    docker-php-ext-enable memcached

#RUN pecl install propro && \
#    docker-php-ext-enable propro && \
#    pecl install raphf && \
#    docker-php-ext-enable raphf && \
#    pecl install pecl_http && \
#    echo "extension=http.so" >> /etc/php7/php.ini

#RUN pecl install pdo_pgsql && \
#     docker-php-ext-enable pdo_pgsql

RUN docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
    mbstring \
    sockets \
    zip

