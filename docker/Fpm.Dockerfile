#FROM php:7.3-fpm

#RUN apt-get update\
#&& docker-php-ext-install pdo pdo_mysql
        FROM php:fpm
#RUN printf "deb http://archive.debian.org/debian/ jessie main\ndeb-src http://archive.debian.org/debian/ jessie main\ndeb http://security.debian.org jessie/updates main\ndeb-src http://security.debian.org jessie/updates main" > /etc/apt/sources.list
#RUN echo "deb [check-valid-until=no] http://archive.debian.org/debian jessie-backports main" > /etc/apt/sources.list.d/jessie-backports.list

# As suggested by a user, for some people this line works instead of the first one. Use whichever works for your case
# RUN echo "deb [check-valid-until=no] http://archive.debian.org/debian jessie main" > /etc/apt/sources.list.d/jessie.list


#RUN sed -i '/deb http:\/\/deb.debian.org\/debian jessie-updates main/d' /etc/apt/sources.list

#UN apt-get -o Acquire::Check-Valid-Until=false update
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
        git\
        sudo\
        vim\
        nano\
        curl\
        wget\
        zip\
        unzip
      
        
        RUN pecl install -o -f raphf \
        && echo "extension=raphf.so" >> /usr/local/etc/php/conf.d/raphf.ini\
        && pecl install -o -f propro \
        && echo "extension=propro.so" >> /usr/local/etc/php/conf.d/propro.ini\
        && pecl install -o -f pecl_http \
        && echo "extension=http.so" >> /usr/local/etc/php/conf.d/http.ini\ 
        && pecl install  -o -f xdebug  memcached redis\
        && docker-php-ext-enable xdebug memcached redis\
        && docker-php-ext-install mbstring\
        && docker-php-ext-install opcache\
        && docker-php-ext-install sockets\
        && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
        && docker-php-ext-install pdo pdo_pgsql pdo_mysql

        RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
       # COPY    ./site/ /var/www/html/
        #COPY    ./config-php-fpm/php-fpm.conf  /usr/local/etc/php-fpm.conf
       # COPY    ./www/www.conf   /usr/local/etc/php-fpm.d/www.conf
        #EXPOSE 80 160

        #CMD ["php-fpm"]