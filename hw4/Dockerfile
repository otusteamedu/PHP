FROM php:latest

RUN apt-get update
# Libs for memcached
RUN apt-get install -y libmemcached11 libmemcachedutil2 build-essential libmemcached-dev libz-dev libpq-dev \
# Install utils
	curl git wget grep

# Install Postgre PDO
RUN docker-php-ext-install pdo pdo_pgsql

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install redis and memcached
RUN pecl install redis \
    && pecl install memcached \
    && docker-php-ext-enable redis memcached 