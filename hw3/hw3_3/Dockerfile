FROM php:7.2-fpm-alpine

RUN apk add php7-dev gcc g++ make \
		&& apk add git \
		&& apk add curl-dev \
		&& apk add wget \
		&& apk add grep \
		&& apk add postgresql-dev \
		&& apk add libmemcached-dev \
        && apk add icu-dev \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of xdebug \
    && docker-php-ext-enable xdebug \
    && pecl install -of memcached \
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && echo "extension=http.so" >> /usr/local/etc/php/conf.d/docker-php-ext-zhttp.ini \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && pecl list

ENV COMPOSER_ALLOW_SUPERUSER 1
WORKDIR /var/www
EXPOSE 80 
CMD ["php-fpm"] 

