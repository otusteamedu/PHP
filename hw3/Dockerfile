FROM php:7.3-cli-alpine

COPY . /usr/src/homework
WORKDIR /usr/src/homework

RUN apk update && \
    apk add git  \
        curl  \
        grep  \
        wget  \
        openrc \
        g++ \
        gcc \
        autoconf \
        unzip \
        make \
        pkgconfig \
        zlib-dev \
        libmemcached libmemcached-dev \
        libsasl \
        php7-pdo_pgsql \
        php7-common \
        musl \
        libpq \
        postgresql-dev \
        libcurl \
        curl-dev \
        python-dev \
        libpq-dev

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php -r "if (hash_file('sha384', 'composer-setup.php') === 'e0012edf3e80b6978849f5eff0d4b4e4c79ff1609dd1e613307e16318854d24ae64f26d17af3ef0bf7cfb710ca74755a') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
    php composer-setup.php && \
    php -r "unlink('composer-setup.php');" && \
    mv composer.phar /usr/local/bin/composer

RUN pecl install redis && \
    docker-php-ext-enable redis

RUN pecl install igbinary && \
    docker-php-ext-enable igbinary && \
    pecl install memcached && \
    docker-php-ext-enable memcached

RUN pecl install propro && \
    docker-php-ext-enable propro && \
    pecl install raphf && \
    docker-php-ext-enable raphf && \
    pecl install pecl_http && \
    echo "extension=http.so" >> /etc/php7/php.ini

RUN pecl install pdo_pgsql && \
     docker-php-ext-enable pdo_pgsql
