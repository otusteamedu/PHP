FROM php:7.4-fpm

LABEL MAINTAINER="Nikita Loparev <loparev7@gmail.com>"

WORKDIR /var/www/hello

RUN apt-get update && apt-get install -y git libz-dev libmemcached-dev \
    curl wget grep && apt-get install \
    && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql 

RUN pecl install redis-5.3.2 
RUN pecl install memcached-3.1.5 
RUN echo extension=memcached.so >> /usr/local/etc/php/conf.d/memcached.ini
RUN docker-php-ext-enable redis memcached

RUN pecl install raphf && pecl install propro && docker-php-ext-enable propro \
    && docker-php-ext-enable raphf \
    && pecl install pecl_http && docker-php-ext-enable http




COPY . .

EXPOSE 8081

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD ["php-fpm"]