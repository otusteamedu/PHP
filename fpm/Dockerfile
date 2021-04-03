FROM php:8.0.0-fpm

RUN apt-get update && apt-get install -y \
        && docker-php-ext-install sockets


COPY php.ini /usr/local/etc/php/php.ini

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
