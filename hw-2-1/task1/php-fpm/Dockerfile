FROM php:7.4-fpm

ARG UID
ARG NGINX_PHP_USER

RUN addgroup --gid $UID --system $NGINX_PHP_USER \
    && adduser --uid $UID --system --disabled-login --disabled-password \
    --gid $UID \
    $NGINX_PHP_USER

ARG PATH_LISTEN_SETTINGS=/usr/local/etc/php-fpm.d/zz-docker.conf

RUN sed -i 's@listen = 9000@listen = /sock/docker.sock@' $PATH_LISTEN_SETTINGS \
    && echo 'listen.owner = '$NGINX_PHP_USER >> $PATH_LISTEN_SETTINGS

WORKDIR /data/site.default
CMD ["php-fpm"]