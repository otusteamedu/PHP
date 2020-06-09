FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
        git \
        curl \
        wget \
        nano \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libonig-dev \
        libzip-dev \
        libpng-dev zlib1g-dev libicu-dev g++ libmagickwand-dev libxml2-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring zip xml gd pdo pdo_mysql \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install imagick \
    && docker-php-ext-enable imagick \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


RUN wget https://getcomposer.org/installer -O - -q \
    | php -- --install-dir=/bin --filename=composer --quiet


RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www

USER 1000:1000

CMD ["php-fpm"]