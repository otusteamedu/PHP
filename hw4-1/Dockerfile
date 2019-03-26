FROM php:7.3.3-cli-alpine3.9

RUN set -xe && \
    apk add --no-cache --virtual .build-deps git php7-dev gcc g++ make && \
    apk add --no-cache libstdc++

RUN set -xe && \
    # Install from PECL
    pecl install -of ds-1.2.8 && \
    # Build from source
    git clone https://github.com/swoole/swoole-src.git /tmp/swoole-src && \
    cd /tmp/swoole-src && \
    phpize && \
    ./configure && \
    make && make install && \
    rm -rf /tmp/swoole-src && \
    docker-php-ext-enable swoole ds

RUN apk del .build-deps
