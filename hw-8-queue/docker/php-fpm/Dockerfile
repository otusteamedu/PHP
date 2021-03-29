FROM php:7.4-fpm

RUN apt-get update && apt-get install -y curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN pecl install -o redis && docker-php-ext-enable redis
RUN pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug

RUN apt-get update && apt-get install -y git

RUN  docker-php-ext-install sockets

ARG UID
ARG NGINX_PHP_USER

RUN addgroup --gid $UID --system $NGINX_PHP_USER \
    && adduser --uid $UID --system --disabled-login --disabled-password \
    --gid $UID \
    $NGINX_PHP_USER

ARG PATH_LISTEN_SETTINGS=/usr/local/etc/php-fpm.d/zz-docker.conf

RUN sed -i 's@listen = 9000@listen = /sock/docker.sock@' $PATH_LISTEN_SETTINGS \
    && echo 'listen.owner = '$NGINX_PHP_USER >> $PATH_LISTEN_SETTINGS

# xdebug
ARG CLIENT_HOST
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN sed -i 's@xdebug.client_host=.*@xdebug.client_host='$CLIENT_HOST'@' /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /data/site.default
CMD ["php-fpm"]
