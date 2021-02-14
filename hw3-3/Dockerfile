FROM php:7.4-fpm

RUN apt-get update

RUN apt-get install -y \
        curl \
        wget \
        git \
        grep 

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions redis memcached pdo_pgsql http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]