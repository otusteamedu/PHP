        FROM php:fpm

        RUN apt-get update && apt-get install -y\
        libargon2-dev \
		libcurl4-openssl-dev \
		libedit-dev \
		libsodium-dev \
		libsqlite3-dev \
		libssl-dev \
		libxml2-dev \
        libmemcached-dev \
        libmsgpack-dev\
		zlib1g-dev \
        libpq-dev\
        libmsgpackc2\
        build-essential \
        pkg-config\
        g++\
        gcc\
        git\
        sudo\
        vim\
        curl\
        wget\
        zip\
        unzip\
        make
        
        RUN pecl install -o -f raphf \
        && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini
        RUN pecl install -o -f propro \
        && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini
        RUN pecl install -o -f pecl_http \
        && echo "extension=http.so" >> /usr/local/etc/php/conf.d/http.ini 
        RUN pecl install  -o -f xdebug  memcached redis\
        && docker-php-ext-enable xdebug memcached redis

        RUN docker-php-ext-install mbstring
        RUN docker-php-ext-install opcache
        RUN docker-php-ext-install sockets
        RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install pdo pdo_pgsql pgsql

        RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
        EXPOSE 80

        CMD ["php-fpm"]