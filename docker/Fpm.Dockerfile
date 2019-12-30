
        FROM php:fpm
        RUN apt-get update && apt-get install -y\
        libargon2-dev\
		libcurl4-openssl-dev \
		libedit-dev \
		libsodium-dev \
		libssl-dev \
		libxml2-dev \
        libmemcached-dev \
        libmsgpack-dev\
		zlib1g-dev \
        libpq-dev\
        libmsgpackc2\
        build-essential \
        pkg-config\
        gnupg2\
        git\
        curl\
        wget\
        zip\
        unzip
		RUN wget -qO - https://www.mongodb.org/static/pgp/server-4.2.asc | apt-key add -
        RUN echo "deb [ arch=amd64 ] https://repo.mongodb.org/apt/ubuntu bionic/mongodb-org/4.2 multiverse" | tee /etc/apt/sources.list.d/mongodb-org-4.2.list
        RUN apt-get update && apt-get install -y\
        mongodb-org-shell\
        mongodb-org-tools
        RUN pecl install -o -f raphf \
        && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini\
        && pecl install -o -f propro \
        && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini\
        && pecl install -o -f pecl_http \
        && echo "extension=http.so" >> /usr/local/etc/php/conf.d/http.ini\
		&& pecl install -o -f mongodb\
		&& echo  "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini\
        && pecl install  -o -f xdebug  memcached redis\
        && docker-php-ext-enable xdebug memcached redis\
        && docker-php-ext-install mbstring\
        && docker-php-ext-install opcache\
        && docker-php-ext-install sockets\
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install pdo pdo_pgsql pdo_mysql

       RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
