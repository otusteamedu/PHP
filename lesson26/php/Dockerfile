FROM php:7.3-fpm
## Install the composer package dependencies + git + procps
RUN apt-get update && apt-get install -y libmcrypt-dev libpq-dev git procps
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && docker-php-ext-install bcmath sockets \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-configure bcmath

# Allow composer to be run as super user
ENV COMPOSER_ALLOW_SUPERUSER 1
# Set the composer home directory
ENV COMPOSER_HOME /tmp
# Set the composer version
ENV COMPOSER_VERSION 1.7.2
