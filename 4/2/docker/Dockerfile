FROM php:7.4-fpm

RUN apt-get update && apt-get install -y curl
RUN docker-php-ext-install sockets

WORKDIR /var/www/html

CMD ["php-fpm"]
