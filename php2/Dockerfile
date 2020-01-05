FROM php:7-fpm
RUN addgroup --gid 3000 --system app && adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app

MAINTAINER Rudin Andrey <rudinandrey@yandex.ru>

RUN apt-get update && apt-get install -y git \ 
&& docker-php-ext-install pdo pdo_mysql \
&& apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd \
&& pecl install redis-5.1.1 \
&& pecl install xdebug-2.8.1
RUN apt-get install -y libcurl4-gnutls-dev \ 
	zlib1g-dev libicu-dev g++ libxml2-dev libpq-dev \
&& docker-php-ext-install curl json xml pdo_pgsql pgsql
RUN apt-get install -y libmemcached-dev zlib1g-dev \
&& pecl install memcached \
&& docker-php-ext-enable memcached redis xdebug
RUN apt-get install -y wget
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
&& php composer-setup.php \
&& php -r "unlink('composer-setup.php');" \
&& mv composer.phar /usr/bin/composer
RUN pecl install -of raphf \
&& docker-php-ext-enable raphf \
&& pecl install -of propro \
&& docker-php-ext-enable propro
RUN apt-get install -y libgnutls28-dev
RUN pecl install -of pecl_http \
&& docker-php-ext-enable --ini-name 06-http.ini http \
&& rm -rf /tmp/*
RUN apt-get install -y libzip-dev \
&& docker-php-ext-install zip


WORKDIR /app

RUN composer global require laravel/installer
RUN echo "export PATH=$PATH:/root/.composer/vendor/bin" >> /root/.bashrc

