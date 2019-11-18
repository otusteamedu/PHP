FROM php:7.3-fpm

RUN apt-get update && apt-get install -y zlib1g-dev libzip-dev unzip

RUN docker-php-ext-install bcmath zip

RUN curl -s https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer
    
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN composer global require laravel/installer

ENV PATH $PATH:/root/.composer/vendor/bin

EXPOSE 9000
CMD ["php-fpm"]