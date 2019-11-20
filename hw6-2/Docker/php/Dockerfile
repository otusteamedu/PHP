FROM php:7.3-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip

RUN docker-php-ext-install bcmath zip

RUN curl -s https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
    
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer global require laravel/installer

ENV PATH $PATH:/root/.composer/vendor/bin

# add user for sockets
RUN addgroup --gid 3000 --system app && \
    adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app

# install laravel
RUN composer create-project --prefer-dist laravel/laravel app

# set permissions for laravel
RUN chown -R www-data:www-data app/storage && \
    chown -R www-data:www-data app/bootstrap/cache && \
    chmod -R 775 app/bootstrap/cache && \
    chmod -R 775 app/storage
    
CMD ["php-fpm"]