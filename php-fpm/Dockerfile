FROM php:7.3-fpm-alpine3.8
ENV PHP_MONGO_VERSION 1.5.3
ENV PHP_REDIS_VERSION 5.0.5

# persistent / runtime deps
ENV PHPIZE_DEPS \
    autoconf \
    cmake \
    file \
    g++ \
    gcc \
    libc-dev \
    pcre-dev \
    make \
    git \
    pkgconf \
    re2c \
    # for GD
    freetype-dev \
    libpng-dev  \
    libjpeg-turbo-dev
ENV PHP_EXTENSIONS \
    gd \
    bcmath \
    intl \
    pcntl \
    mysqli \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    soap \
    iconv \
    opcache
ENV PECL_EXT \
    redis \
    apcu \
    mongodb

RUN apk add --no-cache --virtual .persistent-deps \
    # for intl extension
    icu-dev \
    # for postgres
    postgresql-dev \
    # for soap
    libxml2-dev \
    # for amqp
    libressl-dev \
    # for GD
    freetype \
    libpng \
    libjpeg-turbo
RUN set -xe \
    # workaround for rabbitmq linking issue
    && ln -s /usr/lib /usr/local/lib64 \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
    && docker-php-ext-configure gd \
        --with-gd \
        --with-freetype-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-configure bcmath --enable-bcmath \
    && docker-php-ext-configure intl --enable-intl \
    && docker-php-ext-configure pcntl --enable-pcntl \
    && docker-php-ext-configure mysqli --with-mysqli \
    && docker-php-ext-configure pdo_mysql --with-pdo-mysql \
    && docker-php-ext-configure pdo_pgsql --with-pgsql \
    && docker-php-ext-configure mbstring --enable-mbstring \
    && docker-php-ext-configure soap --enable-soap \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install -j$(nproc) \
        $PHP_EXTENSIONS \
    && pecl -d preferred_state=beta install xdebug \
    && pecl install \
        $PECL_EXT \
    && docker-php-ext-enable \
        $PECL_EXT
# FPM configs
COPY conf.d/fpm/php-fpm.conf /usr/local/etc/
COPY conf.d/fpm/pool.d /usr/local/etc/pool.d

# Php ini file
COPY conf.d/php.ini /usr/local/etc/php/conf.d/
# Php7 ini file
COPY conf.d/php7.ini /usr/local/etc/php/conf.d/
# xdebug ini
COPY conf.d/xdebug.ini /usr/local/etc/php/conf.d/
# mongodb ini
COPY conf.d/mongodb.ini /usr/local/etc/php/conf.d/
# redis ini
COPY conf.d/redis.ini /usr/local/etc/php/conf.d/
RUN apk del .build-deps \
    && rm -rf /tmp/* \
    && rm -rf /app \
    && mkdir /app

# Possible values for ext-name:
# bcmath bz2 calendar ctype curl dba dom enchant exif fileinfo filter ftp gd gettext gmp hash iconv imap interbase intl
# json ldap mbstring mcrypt mssql mysql mysqli oci8 odbc opcache pcntl pdo pdo_dblib pdo_firebird pdo_mysql pdo_oci
# pdo_odbc pdo_pgsql pdo_sqlite pgsql phar posix pspell readline recode reflection session shmop simplexml snmp soap
# sockets spl standard sybase_ct sysvmsg sysvsem sysvshm tidy tokenizer wddx xml xmlreader xmlrpc xmlwriter xsl zip

WORKDIR /var/www
CMD ["php-fpm"]