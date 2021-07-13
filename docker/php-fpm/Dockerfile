FROM php:7.4-fpm

RUN apt-get update \
  && apt-get install -y \
      git \
      curl \
      wget \
      grep \
      zip \
      unzip \
      libmemcached-dev \
      zlib1g-dev \
      libzip-dev \
      libcurl4-openssl-dev \
      libbrotli-dev \
      libevent-dev \
      libicu-dev \
      libidn11-dev \
      libidn2-0-dev \
      libssl-dev \
      libpq-dev \
      libonig-dev \
      librabbitmq-dev \
      nano \
  && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  && pecl install memcached \
  && docker-php-ext-enable memcached \
  && docker-php-ext-install pdo pdo_pgsql pgsql \
  && pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug \
  && pecl install -o redis && docker-php-ext-enable redis \
  && docker-php-ext-install zip sockets bcmath mbstring \
  && pecl install amqp && docker-php-ext-enable amqp \
  && rm -rf /tmp/pear

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php-fpm"]