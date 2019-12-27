FROM php:7-fpm-alpine

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
        postgresql-dev \
        icu-dev \
    	&& curl -sS https://getcomposer.org/installer | php -- \
            --filename=composer \
            --install-dir=/usr/local/bin && \
            echo "alias composer='composer'" >> /root/.bashrc && \
            composer 

RUN pecl install -of xdebug \
    && docker-php-ext-enable --ini-name 00-xdebug.ini xdebug \
    && pecl install -of redis \
    && docker-php-ext-enable --ini-name 01-redis.ini redis \
    && pecl install memcached \
    && docker-php-ext-enable --ini-name 02-memcached.ini memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable --ini-name 03-raphf.ini raphf \
    && pecl install -of propro \
    && docker-php-ext-enable --ini-name 04-propro.ini propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable --ini-name 05-http.ini http

RUN addgroup -g 1000 -S ruben
RUN adduser -u 1000 -S -G ruben ruben

RUN rm /usr/local/etc/php-fpm.d/www.conf
COPY www.conf /usr/local/etc/php-fpm.d
RUN rm /usr/local/etc/php-fpm.d/zz-docker.conf

USER ruben
 
CMD ["php-fpm", "--nodaemonize"]

EXPOSE 3000
