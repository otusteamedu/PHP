FROM php:7.2-fpm-alpine
RUN apk add php7-dev \
&& apk add gcc \
&& apk add g++ \
&& apk add make \
&& apk add git \
&& apk add libmemcached-dev \
&& apk add curl-dev \
&& apk add libpq \
&& apk add postgresql-dev \
&& apk add icu-dev \
&& curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/bin \
        --filename=composer \
&& pecl install -of raphf \
&& docker-php-ext-enable raphf \
&& pecl install -of propro \
&& docker-php-ext-enable propro \
&& pecl install -of pecl_http \
&& echo "extension=http.so" >> /usr/local/etc/php/conf.d/docker-php-ext-zhttp.ini \
&& docker-php-ext-install pdo_pgsql \
&& docker-php-ext-install pdo_mysql \
