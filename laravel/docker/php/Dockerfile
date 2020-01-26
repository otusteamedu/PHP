FROM php:7.4-fpm

RUN apt-get update && \
    apt-get install -y \
    wget \
    git \
    zip \
    zlib1g-dev \
    libmemcached-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    libpq-dev

RUN pecl install memcached \
    && pecl install redis \
    && pecl install raphf \
    && pecl install propro \
    && pecl install xdebug \
    && docker-php-ext-enable memcached redis raphf propro xdebug\
    && pecl install pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install pdo_pgsql

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'baf1608c33254d00611ac1705c1d9958c817a1a33bce370c0595974b342601bd80b92a3f46067da89e3b06bff421f182') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

RUN echo "xdebug.remote_enable=1 \nxdebug.idekey=PHPSTORM \nxdebug.default_enable=0 \nxdebug.remote_connect_back=1 \nxdebug.remote_cookie_expire_time=-9990" >> \
    /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && adduser --disabled-password --gecos "" user \
    && rm /usr/local/etc/php-fpm.d/zz-docker.conf \
    && mkdir /socket \
    && chown user:user /socket