FROM php:7.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y git curl wget grep nano mc procps sudo \
    npm \
    zip unzip \
    build-essential \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
    libfreetype6 libfreetype6-dev \
    locales \
    jpegoptim optipng pngquant gifsicle \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && pecl install -of xdebug && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql zip exif pcntl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

EXPOSE 9000
CMD ["php-fpm"]