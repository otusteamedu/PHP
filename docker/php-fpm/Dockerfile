# php-fpm/Dockerfile
FROM php:7.4-fpm-alpine

COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /app

RUN  rm /usr/local/etc/php-fpm.d/zz-docker.conf \
     && addgroup -g 1000 -S app \
     && adduser -u 1000 -S -D -G app app\
     && apk update \
     && apk add  curl-dev grep git wget libpng libpng-dev libjpeg-turbo-dev libwebp-dev zlib-dev libxpm-dev \
     && pecl channel-update pecl.php.net \
     && docker-php-ext-install mysqli pdo pdo_mysql gd \
     && apk del libpng-dev \
     && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

USER app

CMD ["php-fpm", "--nodaemonize"]
