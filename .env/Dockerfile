FROM php:7.4.1-fpm
RUN apt-get update && \
    apt-get -y install git curl
RUN cd /tmp && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin && \
    rm composer-setup.php && \
    pecl install xdebug-2.8.0 redis && \
    docker-php-ext-enable xdebug redis && \
    docker-php-ext-install -j$(nproc) pdo_mysql
RUN apt-get update && \
     apt-get install -y \
         librabbitmq-dev \
         libssh-dev && \
     docker-php-ext-install \
         bcmath \
         sockets && \
     pecl install amqp &&  \
     docker-php-ext-enable amqp
WORKDIR /var/www/html
CMD ["php-fpm"]