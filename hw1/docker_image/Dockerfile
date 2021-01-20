FROM php:7.4-cli

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -sL https://deb.nodesource.com/setup_15.x | bash - \
    && apt-get install -y git \
    && apt-get install -y wget \
    && apt-get install -y grep \
    && apt-get autoremove \
    && apt-get clean

RUN pecl channel-update pecl.php.net \
    && pecl install -of memcached \
    && pecl install -of redis

RUN echo "extension=memcached.so" > /usr/local/etc/php/conf.d/memcached.ini \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini

COPY . /usr/src/myapp
WORKDIR /usr/src/myapp