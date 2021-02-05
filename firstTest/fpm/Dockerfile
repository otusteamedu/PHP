FROM php:7.3.4-fpm

RUN apt-get update -yqq \
    && apt-get install git wget unzip zlibc zlib1g libzip-dev zlib1g-dev libxml2-dev libssl-dev libicu-dev g++ apt-transport-https sudo gnupg gnupg1 gnupg2 tar libpng-dev -yqq

# install general php extensions
RUN docker-php-ext-install pdo_mysql \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install zip \
    && docker-php-ext-install soap \
    && docker-php-ext-install opcache \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl \
    && docker-php-ext-install gd
    
# install node
RUN curl -sL https://deb.nodesource.com/setup_10.x | sudo -E bash -
RUN apt-get install nodejs npm -yqq

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN sudo apt-get clean

WORKDIR /data

VOLUME /data

CMD ["php-fpm"]