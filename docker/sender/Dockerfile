FROM php:7.4-fpm

WORKDIR /app
RUN apt-get update \
    && apt-get install -y librabbitmq-dev libssh-dev \
    && docker-php-ext-install bcmath sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && addgroup -gid 101 -group nginx \
    && adduser  --gid 101 --disabled-password  nginx

COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

