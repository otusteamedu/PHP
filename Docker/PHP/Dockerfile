FROM php:7

RUN apt-get update && apt-get install -y --no-install-recommends \
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
	    libcurl4-openssl-dev \
	    libevent-dev \
	    libpq-dev \
	    libicu-dev \
	    libssl-dev \
	    redis \
	    memcached \
        && pecl install mcrypt \
	    && docker-php-ext-enable mcrypt \
        && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
	    && docker-php-ext-configure gd --with-freetype --with-jpeg \
        && docker-php-ext-install -j$(nproc) gd \
        && docker-php-ext-install pdo_pgsql \
        && apt-get autoremove

RUN  pecl install raphf propro \
	&& docker-php-ext-enable raphf propro \
	&& pecl install pecl_http-3.2.4 \ 
	&& docker-php-ext-enable http

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

VOLUME /app

CMD ["php-fpm"]