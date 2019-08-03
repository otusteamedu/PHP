FROM php:7.1-fpm

ENV TIMEZONE Europe/Moscow
ENV PHP_MEMORY_LIMIT 1024M
ENV MAX_UPLOAD 128M
ENV PHP_MAX_FILE_UPLOAD 128
ENV PHP_MAX_POST 128M

RUN apt-get update && apt-get install -y -f software-properties-common apt-utils mc wget nano git grep curl unzip tar gnupg zlib1g-dev libmemcached-dev build-essential \
    openssl libcurl4-openssl-dev libpq-dev libssl-dev libpq5 pkg-config
RUN apt-get install --reinstall -y procps

RUN docker-php-ext-install sockets
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql


ENV RABBITMQ_C_VERSION 0.7.1
RUN curl -L -o /tmp/rabbitmq.tar.gz https://github.com/alanxz/rabbitmq-c/releases/download/v$RABBITMQ_C_VERSION/rabbitmq-c-$RABBITMQ_C_VERSION.tar.gz \
    && tar xfz /tmp/rabbitmq.tar.gz \
    && rm -r /tmp/rabbitmq.tar.gz \
    && cd rabbitmq-c-$RABBITMQ_C_VERSION \
    && ./configure \
    && make \
    && make install 
                     
RUN if [ -z `php -m | grep -i "amqp"` ];then  \     
    pecl install amqp && docker-php-ext-enable amqp \
    ;fi
                     

RUN curl -s https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

