FROM php:7.2-fpm

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libssl-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libicu-dev \
        libpcre3-dev \
        libcurl4-openssl-dev \
        zlib1g-dev \
        libz-dev \
        libmemcached-dev \
        libmemcached11 \
        libmemcachedutil2 \
        build-essential \
        libpq-dev \
    && docker-php-ext-install -j$(nproc) zip \
    && docker-php-ext-install sockets \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && pecl install redis \
    && pecl install memcached \
    && pecl install raphf \
    && docker-php-ext-enable raphf \
    && pecl install propro \
    && docker-php-ext-enable propro \
    && pecl install pecl_http \
    && docker-php-ext-enable redis memcached http \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /var/www

CMD ["php-fpm"]
