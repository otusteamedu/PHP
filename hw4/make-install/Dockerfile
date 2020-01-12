FROM php:7.3-fpm

RUN apt-get update \
    && apt-get install -y git curl wget grep nano mc \
    && cd /tmp \
    && git clone https://github.com/xdebug/xdebug.git \
    && cd xdebug \
    # && ../configure --enable-xdebug --with-php-config=/path/to/php-config \
    # && make clean \
    # && make>>make_output.txt \
    # && make install
    && phpize && ./configure --enable-xdebug-dev \
    && make clean \
    && make all >>make_output.txt && make install \
    && cp /tmp/xdebug/make_output.txt /var/www/html/make_output.txt

WORKDIR /var/www/html
CMD ["php-fpm"]