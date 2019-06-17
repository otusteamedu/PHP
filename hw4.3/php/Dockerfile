FROM php:7.1-fpm-alpine

# git
RUN apk --update add git && rm /var/cache/apk/*

RUN apk add zlib-dev libmemcached-dev libmemcached postgresql-dev

# php extensions
RUN  apk add --no-cache $PHPIZE_DEPS
RUN docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install pdo_pgsql && \
    docker-php-ext-install sockets && \
    pecl install redis && docker-php-ext-enable redis && \
    pecl install memcached && docker-php-ext-enable memcached && \
    pecl install xdebug && docker-php-ext-enable xdebug && \
    # install pcntl
    docker-php-ext-install pcntl

#install gd zip
RUN apk add --no-cache zlib libjpeg-turbo-dev libwebp-dev zlib-dev libxpm-dev libpng libpng-dev && \
    docker-php-ext-install gd && docker-php-ext-install zip && apk del libpng-dev


RUN set -ex \
&& apk add --no-cache bash build-base wget curl m4 autoconf libtool imagemagick imagemagick-dev zlib zlib-dev libcurl curl-dev libevent libevent-dev libidn libidn-dev \
&& printf "\n" | pecl install raphf propro \
&& docker-php-ext-enable raphf propro \
&& printf "\n" | pecl install pecl_http \
&& echo -e "extension=raphf.so\nextension=propro.so\nextension=http.so" > /usr/local/etc/php/conf.d/docker-php-ext-http.ini \
&& rm -rf /usr/local/etc/php/conf.d/docker-php-ext-raphf.ini \
&& rm -rf /usr/local/etc/php/conf.d/docker-php-ext-propro.ini


# composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# bash tools and openssh
RUN apk add --no-cache bash gawk sed grep bc coreutils openssh mc wget

RUN docker-php-ext-install opcache
RUN docker-php-ext-enable opcache

# mysql-client
RUN apk add mysql-client

RUN apk add icu icu-dev
RUN apk add php7-intl
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

RUN  rm -rf /tmp/* /var/cache/apk/*