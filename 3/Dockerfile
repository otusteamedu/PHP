FROM php

WORKDIR /tmp
RUN apt update \
	&& apt upgrade \ 
	&& apt install -y git wget zlib1g-dev libmemcached-dev libpq-dev libcurl4-openssl-dev openssl libssh-dev \
	&& curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && echo "no\n" | pecl install redis \
    && echo extension=redis.so > /usr/local/etc/php/conf.d/redis.ini \
    && echo "no\n" | pecl install -o memcached \ 
    && echo extension=memcached.so > /usr/local/etc/php/conf.d/memcached.ini \
    && pecl install -o raphf \
    && echo extension=raphf.so > /usr/local/etc/php/conf.d/raphf.ini \
    && pecl install -o propro \
    && echo extension=propro.so > /usr/local/etc/php/conf.d/propro.ini \
    && echo "/usr\n" | pecl install -o pecl_http \
    && echo extension=http.so > /usr/local/etc/php/conf.d/http.ini \
    # Пытался установить также через команду pecl install -o pdo_pgsql,
    # но выдавала ошибку, погуглил, пробовал добавить всякие системные пакеты 
    # так и не понял, почему не запустилась, поэтому для pdo_pgsql
    # использовал такую команду.
    && docker-php-ext-install pdo pdo_pgsql

