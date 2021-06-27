FROM php:7.4.6-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libzip-dev \
        libmcrypt-dev \
        sendmail \
         libpq-dev \
    && pecl install mcrypt-1.0.3 \
       redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install pdo pdo_pgsql \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) pgsql iconv mbstring mysqli pdo_mysql zip\
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install sockets \
        && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

VOLUME /var/www/html

EXPOSE 9000

CMD ["php-fpm"]