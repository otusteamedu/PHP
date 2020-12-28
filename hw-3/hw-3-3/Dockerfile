FROM php:7.3-fpm

RUN apt-get update && apt-get install -y libpq-dev

RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd

RUN docker-php-ext-install mbstring

RUN apt-get install -y zip libzip-dev \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip

RUN pecl install xdebug-2.9.2 \
    && docker-php-ext-enable xdebug
RUN echo "xdebug.remote_port=9000\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_autostart=1\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_enable=1\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_connect_back=0\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_host=host.docker.internal\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=PHPSTORM\n" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN apt-get update && apt-get install git -y

RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN docker-php-ext-install pdo pdo_mysql exif

RUN apt-get -yqq update
RUN apt-get -yqq install exiftool
RUN docker-php-ext-configure exif
RUN docker-php-ext-install exif
RUN docker-php-ext-enable exif

RUN pecl install redis && docker-php-ext-enable redis

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

RUN chown -R www-data:www-data /var/www
RUN chmod -R 755 /var/www

USER root


WORKDIR /var/www
