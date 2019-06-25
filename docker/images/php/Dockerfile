FROM php:7.3-fpm

#main utils
RUN apt-get update && apt-get install -y \
        procps \
        curl \
        wget \
        git \
        grep \
        libxml2-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libmemcached-dev zlib1g-dev libcurl4-openssl-dev libssl-dev \
        libpq-dev libzip-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath ctype tokenizer
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
RUN docker-php-ext-install xml

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /apps

CMD ["php-fpm"]
