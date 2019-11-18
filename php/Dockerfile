FROM php:7.3-fpm

RUN apt-get update && apt-get install -y \
	git

RUN pecl install redis \
    && docker-php-ext-enable redis

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php-fpm"]