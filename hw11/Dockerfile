FROM php:7.3-fpm

# update package list
RUN apt-get update

# git, curl, unzip, wget, grep
RUN apt-get install -y  git \
			curl \
			unzip \
			wget \
			grep \
			libzip-dev \
			libpq-dev \
			zlib1g-dev \
			zlib1g-dev \
			libssl-dev \
			libcurl4-openssl-dev \
			libmemcached-dev

# composer
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

# redis
RUN pecl install -of redis
RUN echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini

# memcached
RUN pecl install -of memcached
RUN echo "extension=memcached.so" >> /usr/local/etc/php/conf.d/memcached.ini

# pecl_http
RUN pecl install -of raphf propro
RUN docker-php-ext-enable raphf propro
RUN pecl install -of pecl_http

# pdo_pgsql
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql zip

WORKDIR /code

CMD ["php-fpm"]
