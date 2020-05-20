FROM php:7.4-cli

RUN apt-get update
RUN apt-get install -y git
RUN apt-get install -y curl
RUN apt-get install -y wget
RUN pecl install redis-5.1.1
RUN pecl install xdebug-2.8.1
# Не получилось установить, выдавал ошибку на каждом пакете и не шёл дальше
#RUN pecl install memcached-2.2.0
#RUN docker-php-ext-enable memcached
#RUN pecl install pdo-1.0.3
#RUN docker-php-ext-enable pdo
#RUN pecl install pdo_pgsql-1.0.2
#RUN docker-php-ext-enable pdo_pgsql

RUN curl -s http://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY . /var/www/otus-php
WORKDIR /var/www/otus-php

CMD ["composer", "install"]
CMD ["php", "./src/protect.php"]