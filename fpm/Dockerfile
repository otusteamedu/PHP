FROM php:7.4-fpm

# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
		nano \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
		libpng-dev \
		libonig-dev \
		libzip-dev \
		libmcrypt-dev \
		libpq-dev \
		libmemcached-dev \
		zlib1g-dev \
        && pecl install mcrypt-1.0.3 redis memcached raphf propro pecl_http \
	&& docker-php-ext-enable mcrypt redis memcached raphf propro \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql pdo_pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd

WORKDIR /var/www/balancer.local

EXPOSE 9000

CMD ["php-fpm"]
