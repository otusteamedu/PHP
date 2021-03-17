FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        mc \
        bash

RUN docker-php-ext-install sockets

WORKDIR /var/www/html

VOLUME /var/www/html

CMD ["php-fpm"]
