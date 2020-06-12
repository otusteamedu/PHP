FROM php:7.4-fpm-alpine

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

WORKDIR /var/www/html

RUN apk update \
     && apk add php7-dev gcc g++ make curl-dev grep git wget postgresql-dev \
        libmemcached-dev  openssl-dev libressl-dev libcurl libevent-dev  \
     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
     && pecl channel-update pecl.php.net \
     && pecl install -of memcached && docker-php-ext-enable memcached \
     && pecl install -of xdebug  && docker-php-ext-enable xdebug \
     && pecl install -of redis && docker-php-ext-enable redis \
     && pecl install -of raphf  && docker-php-ext-enable raphf \
     && pecl install -of propro && docker-php-ext-enable propro \
     && docker-php-ext-install pdo pdo_pgsql sockets \
     && pecl install -of pecl_http \
     && echo "extension=http.so" >> /etc/php7/php.ini

CMD ["php-fpm"]