FROM php:7.0-fpm

RUN apt-get update && apt-get install -y \
	curl \
	wget \
	git \
	libfreetype6-dev \
	libjpeg62-turbo-dev \
	libxslt-dev \
	libicu-dev \
	libmcrypt-dev \
	libpng-dev \
	libxml2-dev \

	&& docker-php-ext-install -j$(nproc) iconv mcrypt mbstring mysqli pdo_mysql zip \
	&& docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
	&& docker-php-ext-install -j$(nproc) gd


WORKDIR /var/www/mysite.dev
COPY /nginx/hosts/mysite.dev.conf /etc/nginx/sites-enabled/mysite.dev.conf
COPY /nginx/www/ /var/www/mysite.dev

CMD ["php-fpm"]

