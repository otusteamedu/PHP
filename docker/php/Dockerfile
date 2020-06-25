FROM php:7-fpm-alpine
WORKDIR /home/www/mysite.local

COPY ./php.ini /usr/local/etc/php/
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

RUN apk add php7-dev \
        bash \
        gcc \
        g++ \
        make \
        curl \
        git \
        wget \
        grep \
        libmemcached-dev \
        zlib-dev \
        curl-dev \
        libpq \
        icu-dev \
    && curl -sS https://getcomposer.org/installer | php -- \
            --filename=composer \
            --install-dir=/usr/local/bin && \
            echo "alias composer='composer'" >> /root/.bashrc && \
            composer \
    && docker-php-ext-install sockets \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx \
    && rm -rf /tmp/*

EXPOSE 9000
CMD ["php-fpm"]