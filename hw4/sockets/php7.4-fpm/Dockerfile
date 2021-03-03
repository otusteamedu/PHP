FROM php:7.4-fpm

RUN docker-php-ext-install sockets

WORKDIR /var/www

VOLUME /code

CMD ["php-fpm"]
