FROM php:fpm

RUN apt-get update && apt-get install -y \
        wget \
        git \
            --no-install-recommends

RUN pecl install -of xdebug \
        redis \
#        memcached \
        pecl_http \
#        pdo_pgsql \
    && rm -rf /tmp/pear

COPY ./install-composer.sh /
COPY ./php.ini /usr/local/etc/php/
COPY ./www.conf /usr/local/etc/php/

RUN apt-get purge -y g++ \
    && apt-get autoremove -y \
    && rm -r /var/lib/apt/lists/* \
    && rm -rf /tmp/* \
    && sh /install-composer.sh \
    && rm /install-composer.sh

RUN usermod -u 1000 www-data

WORKDIR /home/www/mysite.local

EXPOSE 9000
CMD ["php-fpm"]