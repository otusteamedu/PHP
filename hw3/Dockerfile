FROM php:7.2-fpm
RUN apt-get update -y && apt-get install -y \
	&& apt-get install wget -y && apt-get install git -y \
	&& curl -sS https://getcomposer.org/installer -o composer-setup.php \
	&& php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
	&& pecl install redis && docker-php-ext-enable redis \
	&& apt-get install -y libmemcached-dev zlib1g-dev \
	&& pecl install memcached && docker-php-ext-enable memcached 

RUN pecl install raphf propro \
	&& docker-php-ext-enable raphf propro \
	&& apt-get install -y libcurl4 libcurl4-openssl-dev libssl-dev \
	&& pecl install pecl_http && docker-php-ext-enable http

RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

#RUN pecl list
#RUN php -m | grep pdo

RUN apt-get install -y nginx \
	&& php-fpm -t \
	&& mkdir /var/run/php-fpm \
	&& echo listen = /var/run/php-fpm/www.socket >> /usr/local/etc/php-fpm.d/www.conf #ENABLE SOCKET INTERACTION
	#&& tail /usr/local/etc/php-fpm.d/www.conf
