FROM php:7.2-fpm
RUN apt-get update && apt-get install -y git curl wget nano \
	&& mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini" \
	&& pecl install -o redis-5.1.1 && docker-php-ext-enable redis \
	&& apt-get install -y zlib1g-dev libmemcached-dev \
		&& pecl install -o memcached 3.1.5 \
		&& docker-php-ext-enable memcached \
	&& pecl install -o raphf 2.0.1 && docker-php-ext-enable raphf \
	&& pecl install -o propro 2.1.0 && docker-php-ext-enable propro \
	&& apt-get install libcurl3-dev \
	&& apt-get install libssl-dev \
	&& pecl install -o pecl_http 3.2.3 && docker-php-ext-enable http \
	&& apt-get install -y libpq-dev && docker-php-ext-install pdo_pgsql \
	&& curl -sS https://getcomposer.org/installer | php -- \
	 --install-dir=/usr/local/bin --filename=composer		
