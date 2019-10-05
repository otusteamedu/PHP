FROM php:7.1-fpm-alpine
MAINTAINER Zvery Carnivorous
RUN apk add php7-dev \
&& apk add gcc \
&& apk add g++ \
&& apk add make \
&& apk add nano \
&& apk add curl \
&& apk add git \
&& apk add wget \
&& apk add grep\
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
&&  docker-php-ext-enable http \
&& docker-php-ext-install pdo \
&& docker-php-ext-install pdo_pgsql \
&& docker-php-ext-enable pdo
