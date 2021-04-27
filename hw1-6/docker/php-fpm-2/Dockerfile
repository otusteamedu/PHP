FROM php:7.4-fpm
# ставим необходимые для нормальной работы модули
RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        grep \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
    && pecl install mcrypt-1.0.3 \
	&& docker-php-ext-enable mcrypt \
#	&& htop \
   #     && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip pecl_http pdo_pgsql redis memcached\
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY php-fpm-2/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY socket/php-fpm.sock /var/run/php-fpm/php-fpm.sock

WORKDIR /var/www/hw.loc

VOLUME /var/www/hw.loc

CMD ["php-fpm"]

