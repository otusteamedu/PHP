FROM php:7.2-fpm

RUN apt-get update && \
    apt-get -y install git curl wget grep vim libz-dev libmemcached-dev
RUN cd /tmp && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin && \
    rm composer-setup.php
RUN pecl install -of redis && \
    echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini && \
    pecl install -of memcached && \
    echo "extension=memcached.so" >> /usr/local/etc/php/conf.d/memcached.ini && \
    apt-get install -y zlib1g-dev libssl-dev libcurl4-openssl-dev && \
    pecl install -of raphf propro && \
    docker-php-ext-enable raphf propro && \
    pecl install -of pecl_http && \
    docker-php-ext-enable http && \
    apt-get install -y libpq-dev && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-install sockets

WORKDIR /var/www

CMD ["php-fpm"]

# docker exec -it PingPong sh