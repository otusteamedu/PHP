FROM php:7.4

RUN apt-get update && apt-get install -y \
        curl \
        wget \
        git \
        grep \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
	libpng-dev \
	libonig-dev \
	libzip-dev \
	libmcrypt-dev \
	libpq-dev \
        && pecl install mcrypt-1.0.3 \
        && pecl install pecl_http \
	&& docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
        #&& docker-php-ext-install libpq-dev \
        #&& docker-php-ext-install pdo_pgsql \
	&& docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd
         
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql
                     
WORKDIR /code

VOLUME /code

CMD [ "php", "index.php" ]
