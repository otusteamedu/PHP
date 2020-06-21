# php-fpm/Dockerfile
FROM php:7.4-fpm-alpine

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /app

ARG UID

RUN addgroup -g $UID  -S app
RUN adduser -u $UID -S -G app app

RUN apk add php-sockets php7-dev gcc g++ make curl-dev grep git wget postgresql-dev \
        libmemcached-dev openssl-dev libressl-dev libcurl  libzip-dev zip libevent-dev  \
     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
     && pecl channel-update pecl.php.net \
     && pecl install -of memcached && docker-php-ext-enable memcached \
     && pecl install -of xdebug  && docker-php-ext-enable xdebug \
     && pecl install -of redis && docker-php-ext-enable redis \
     && pecl install -of raphf  && docker-php-ext-enable raphf \
     && pecl install -of propro && docker-php-ext-enable propro \
     && docker-php-ext-install zip pcntl sockets bcmath pdo pdo_pgsql \
     && pecl install -of pecl_http \
     && echo "extension=http.so" >> /etc/php7/php.ini

USER app

CMD ["php-fpm", "--nodaemonize"]
