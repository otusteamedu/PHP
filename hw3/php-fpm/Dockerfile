FROM php:8.0-fpm

RUN apt-get update && apt-get install -y \
		curl \
		wget \
		git \
		nano \
		mc \
		libc-dev \
		libssl-dev \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libicu-dev \
		libonig-dev \
		libzip-dev \
		libmcrypt-dev \
		libcurl4-openssl-dev \
		libmemcached-dev \
		libpq-dev \
	&& pear config-set php_ini "$PHP_INI_DIR" \
	&& pecl install redis && docker-php-ext-enable redis \
	&& pecl install memcached && docker-php-ext-enable memcached \
    && pecl install mcrypt-1.0.4 && docker-php-ext-enable mcrypt \
    && docker-php-ext-install -j$(nproc) pdo_mysql pgsql pdo_pgsql zip \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
	### xdebug ###
	&& cd /var/tmp \
	&& wget https://xdebug.org/files/xdebug-3.0.2.tgz \
	&& tar -xzf xdebug-3.0.2.tgz \
	&& cd xdebug-3.0.2 \
	&& phpize \
	&& ./configure --enable-xdebug \
	&& make > /var/tmp/make_output.txt && make install \
	### composer ###
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
	### cleaning ###
	&& apt-get autoremove -y && apt-get autoclean -y && apt-get clean -y \
	&& rm -rf /var/lib/apt/lists/* /var/tmp/xdebug-3.0.2.tgz \
	&& rm -r /var/tmp/xdebug-3.0.2

ADD php.ini /usr/local/etc/php/

WORKDIR /var/www

EXPOSE 9000

CMD ["php-fpm"]