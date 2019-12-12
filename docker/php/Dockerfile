FROM php:7.3-fpm-alpine
WORKDIR /home/www/mysite.local
ENV MEMCACHED_DEPS zlib-dev libmemcached-dev cyrus-sasl-dev

COPY ./php.ini /usr/local/etc/php/
COPY ./zz-docker.conf /usr/local/etc/php-fpm.d/

RUN apk add php7-dev \
    && apk add bash \
    && apk add gcc \
    && apk add g++ \
    && apk add make \
    && apk add nano \
    && apk add curl \
    && apk add git \
    && apk add wget \
    && apk add grep \
    && apk add libmemcached-dev \
    && apk add zlib-dev \
    && apk add curl-dev \
    && apk add libpq \
    && apk add postgresql-dev \
    && curl -sS https://getcomposer.org/installer | php -- \
            --filename=composer \
            --install-dir=/usr/local/bin && \
            echo "alias composer='composer'" >> /root/.bashrc && \
            composer \
    && pecl install -of xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install memcached \
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable pecl_http \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-enable pdo \
    && docker-php-ext-install sockets \
    && addgroup -g 101 -S nginx \
    && adduser -u 101 -D -S -G nginx nginx \
    && rm -rf /tmp/*

EXPOSE 9000
CMD ["php-fpm"]