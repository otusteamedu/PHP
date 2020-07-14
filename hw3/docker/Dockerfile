FROM php:7.4.6-fpm 
RUN apt-get update && apt-get install -y \
		git curl wget grep libmemcached-dev zlib1g-dev libcurl4-gnutls-dev libgnutls28-dev libpq-dev \
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
		&& docker-php-ext-install pdo_pgsql