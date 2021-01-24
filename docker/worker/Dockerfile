FROM php:7.4-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y librabbitmq-dev libssh-dev npm git zip unzip\
    && docker-php-ext-install bcmath sockets mysqli pdo_mysql exif \
    && pecl install amqp redis \
    && docker-php-ext-enable amqp redis

CMD ["php", "artisan", "queue:work"]
