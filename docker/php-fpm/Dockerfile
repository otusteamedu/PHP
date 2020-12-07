FROM php:7.4-fpm

RUN apt-get update && apt-get install -y wget git unzip librabbitmq-dev libssh-dev \
    && docker-php-ext-install bcmath sockets \
    && pecl install xdebug-2.9.8 amqp mongodb \
    && docker-php-ext-enable xdebug amqp mongodb

ADD ./php.ini /usr/local/etc/php/php.ini

RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www
