FROM php:latest

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libfreetype6-dev \
    libwebp-dev \
    libjpeg62-turbo-dev \
    libgmp-dev \
    libldap2-dev \
    libmemcached-dev \
    libxpm-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    zip \
    unzip && \
    pecl install xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip

RUN pecl install redis \
   && pecl install memcached \
   && docker-php-ext-enable redis memcached