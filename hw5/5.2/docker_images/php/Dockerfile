FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libcurl4-openssl-dev \
    curl \
    imagemagick \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libmcrypt-dev \
    libxml2-dev \
    openssl \
    libssl-dev \
    && pecl install mcrypt-1.0.3 \
    && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) \
        zip \
        mbstring \
        intl \
        pdo \
        pdo_mysql \
        bcmath \
        xml \
        ctype \
        tokenizer \
        curl \
    && docker-php-ext-configure intl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

CMD ["php-fpm"]
