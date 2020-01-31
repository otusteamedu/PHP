FROM php:7.4.1-fpm
RUN apt-get update && \
    apt-get -y install git curl
RUN cd /tmp && \
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin && \
    rm composer-setup.php
RUN pecl install -of redis \
    && echo "extension=redis.so" >> /usr/local/etc/php/conf.d/redis.ini \
    && pecl install mongodb \
    && echo "extension=mongodb.so" >> `php --ini | grep "Loaded Configuration" | sed -e "s|.*:\s*||"` \
    && pecl install xdebug-2.8.0 \
    && docker-php-ext-enable mongodb redis xdebug
RUN docker-php-ext-install sockets
WORKDIR /var/www/html
CMD ["php-fpm"]