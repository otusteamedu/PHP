FROM php

MAINTAINER ag.sidorov<ag.sidorov@gmail.com>

RUN apt-get update -qq \
    && apt-get install --no-install-recommends -qy libmcrypt-dev zlib1g-dev libidn11-dev libcurl3 libpcre3-dev libcurl4-openssl-dev libevent-dev libzip-dev libicu-dev libssl-dev libpq-dev libmemcached-dev zip curl grep wget git ssh \
    && apt-get autoremove -yq --purge \
    && rm -rf /tmp/* /var/tmp/* /var/lib/apt/lists/* \
    && docker-php-ext-install intl \
    && docker-php-ext-install -j$(nproc) mysqli \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip \
    && pecl install raphf \
    && pecl install propro \
    && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && pecl install pecl_http \
    && echo "extension=http.so" >> /usr/local/etc/php/conf.d/pecl-http.ini \
    && docker-php-ext-install pdo_pgsql \
    && git clone https://github.com/php-memcached-dev/php-memcached /usr/src/php/ext/memcached \
    && cd /usr/src/php/ext/memcached \
    && docker-php-ext-configure memcached \
    && docker-php-ext-install memcached \
    && pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis \
    && pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]