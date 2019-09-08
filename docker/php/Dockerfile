FROM php:7.3-fpm

RUN apt-get update && apt-get install -y git nano curl zlib1g-dev libzip-dev libpq-dev

RUN docker-php-ext-install zip && docker-php-ext-enable zip

RUN docker-php-ext-install pdo pdo_pgsql && docker-php-ext-enable pdo pdo_pgsql

WORKDIR /var/www/app

CMD ["php-fpm"]