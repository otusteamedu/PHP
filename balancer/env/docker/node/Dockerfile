FROM php:7.4-fpm-alpine

RUN apk update \
    && apk upgrade --available \
    && apk add --virtual \
        icu-dev \
        curl \
        wget \
        bash \
        nginx \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && docker-php-ext-install -j"$(getconf _NPROCESSORS_ONLN)" \
          sockets

RUN addgroup nginx www-data && \
    mkdir mkdir /sock/ && \
    chown -Rf www-data:www-data /sock/ && \
    mkdir -p /run/nginx

COPY ./php/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./bootstrap.sh /root

WORKDIR /root
CMD ["sh", "bootstrap.sh"]