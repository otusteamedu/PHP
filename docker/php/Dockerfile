FROM php:7.4-fpm

WORKDIR /var/www/html
RUN apt-get update \
    && apt-get install -y librabbitmq-dev libssh-dev npm git zip unzip\
    && docker-php-ext-install bcmath sockets mysqli pdo_mysql exif \
    && pecl install amqp redis \
    && docker-php-ext-enable amqp redis \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
#    && addgroup -gid 101 -group nginx \
#    && adduser  --gid 101 --disabled-password  nginx

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

