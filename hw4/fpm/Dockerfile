FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули

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
        libmemcached-dev \
        && pecl install mcrypt-1.0.3 \
	    && docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	    && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && pecl install memcached \
        && docker-php-ext-enable memcached \
        && pecl install -o -f redis \
        && rm -rf /tmp/pear \
        && docker-php-ext-enable redis


#RUN curl https://pecl.php.net/get/pecl_http --output /tmp/pecl_http.tgz \
#    && cd /tmp \
#    && tar xvf pecl_http.tgz \
#    && cd pecl_http \
#    && phpize \
#    && ./configure \
#    && make \
#    && make install \
#    && docker-php-ext-enable pecl_http

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]
