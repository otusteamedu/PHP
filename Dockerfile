FROM php:7.2-fpm-alpine
RUN apk add php7-dev gcc g++ make \
    && apk add curl-dev \
    && apk add grep \
    && apk add git \
    && apk add wget \
    && apk add icu-dev \
    && apk add postgresql-dev \
    && apk add libmemcached-dev \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \
    && docker-php-ext-enable redis memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-install pdo pdo_pgsql \
    && echo "extension=http.so" >> /usr/local/etc/php/conf.d/docker-php-ext-zhttp.ini \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/app
EXPOSE 80
CMD ["php-fpm"]