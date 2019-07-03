FROM php:7.3-fpm
## Install the composer package dependencies
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && docker-php-ext-install bcmath sockets \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-configure bcmath

# Allow composer to be run as super user
ENV COMPOSER_ALLOW_SUPERUSER 1
# Set the composer home directory
ENV COMPOSER_HOME /tmp
# Set the composer version
ENV COMPOSER_VERSION 1.7.2
