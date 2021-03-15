FROM php:7.4.6-fpm

ENV COMPOSER_ALLOW_SUPERUSER 1

COPY php.ini /usr/local/etc/php/conf.d/php.ini

RUN apt-get update && apt-get install -y \
		git curl wget grep libmemcached-dev zlib1g-dev libcurl4-gnutls-dev libgnutls28-dev libpq-dev libpng-dev libzip-dev libonig-dev autoconf g++ make zip unzip \
		&& pecl install redis-5.2.2 \
		&& pecl install xdebug-2.9.6 \
		&& pecl install memcached-3.1.5 \
		&& pecl install raphf-2.0.1 \
		&& docker-php-ext-enable raphf \
		&& pecl install propro-2.1.0 \
		&& docker-php-ext-enable propro \
		&& pecl install pecl_http-3.2.3 \
		&& docker-php-ext-enable redis xdebug \
		&& docker-php-ext-enable memcached \
		&& docker-php-ext-install pdo \
		&& docker-php-ext-install pdo_pgsql \
		&& docker-php-ext-install iconv \
		&& docker-php-ext-install pdo_pgsql gd zip json curl bcmath mbstring exif pcntl sockets \
		&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

VOLUME /var/www/html

EXPOSE 9000

CMD ["php-fpm"]