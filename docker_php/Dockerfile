FROM php:fpm-alpine3.11

# Загружаем утилиты
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
        curl-dev \
        busybox

# Загружаем composer
#RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
#    php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
#    php composer-setup.php && \
#    php -r "unlink('composer-setup.php');" && \
#    mv composer.phar /usr/local/bin/composer

# устанавливаем redis
RUN pecl install redis && \
    docker-php-ext-enable redis

RUN pecl install mongodb  && \
    echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"` && \
    echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

# устанавливаем memcached
RUN pecl install igbinary && \
    docker-php-ext-enable igbinary && \
    NPROC=$(getconf _NPROCESSORS_ONLN) && \
    mkdir -p /usr/src/php/ext && \
    cd /usr/src/php/ext && \
    pecl bundle redis && \
    docker-php-ext-configure redis --enable-redis-igbinary --enable-redis-lzf && \
    docker-php-ext-install -j${NPROC} redis && \
    cd -


#    pecl install memcached && \
#    docker-php-ext-enable memcached

# устанавливаем pecl_http
#RUN pecl install propro && \
#    docker-php-ext-enable propro && \
#    pecl install raphf && \
#    docker-php-ext-enable raphf && \
#    pecl install pecl_http && \
#    echo "extension=http.so" >> /etc/php7/php.ini

# устанавливаем pdo_pgsql
RUN docker-php-ext-install pdo_pgsql

RUN apk add --no-cache tini openrc busybox-initscripts

RUN apk add php-sockets && \
    docker-php-ext-install pcntl && \
    docker-php-ext-install sockets

RUN addgroup -g 3000 -S app
RUN adduser -u 3000 -S -D -G app app
# RUN rc-service crond start && rc-update add crond

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /usr/src/mysite.local

