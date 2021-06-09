FROM php:8-fpm

RUN apt-get update && apt-get install -y \
        curl \
        net-tools \
        iputils-ping \
        wget \
        git \
        grep \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
    && pecl install mcrypt \
	&& docker-php-ext-enable mcrypt \
#	&& htop \
   #     && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip pecl_http pdo_pgsql redis memcached\
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

    RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

    # Install Postgre PDO
    RUN apt-get install -y libpq-dev \
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install pdo pdo_pgsql pgsql

# COPY --from=composer /usr/bin/composer /usr/bin/composer
# Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www/hw.loc

VOLUME /var/www/hw.loc

CMD ["php-fpm"]

