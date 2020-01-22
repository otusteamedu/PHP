FROM php:7.4-fpm
RUN apt-get update && apt-get install -y \
    git \
    wget \
    curl \
    zlib1g-dev \
    libmemcached-dev \
    libevent-dev \
    libicu-dev \
    libidn2-dev \
    libssl-dev \
    libcurl4-openssl-dev \
    libpq-dev \
    libz-dev \
    nginx \
    vim \
    mc

RUN pecl install -of redis \
    && docker-php-ext-enable redis \
    && pecl install -of memcached \
    && docker-php-ext-enable memcached \
    && pecl install -of raphf \
    && docker-php-ext-enable raphf \
    && pecl install -of propro \
    && docker-php-ext-enable propro \
    && pecl install -of pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install pdo pdo_pgsql pgsql sockets

RUN wget https://getcomposer.org/composer-stable.phar \
    && mv /var/www/html/composer-stable.phar /usr/bin/composer \
    && chmod a+x /usr/bin/composer

CMD ["sh", "-c", "nginx && php-fpm"]