FROM php:7.3-fpm-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
        autoconf \
        build-base \
        icu-dev \
        libevent-dev \
        openssl-dev \
        zlib-dev \
        libzip \
        libzip-dev \
        zlib \
        zlib-dev \
        bzip2 \
        git \
        curl \
        wget \
        nginx

ARG UID
RUN addgroup -g $UID -S app \
  && adduser -u $UID -S -D -G app app

COPY php/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY nginx/default.conf /etc/nginx/conf.d/default.conf

COPY start.sh /root
WORKDIR /root
CMD ["sh", "start.sh"]