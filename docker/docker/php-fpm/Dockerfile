FROM php:7.4-fpm

ARG UID
ARG NGINX_PHP_USER
ENV DOCKER_PATH=/usr/local/etc/php-fpm.d/zz-docker.conf

COPY zz-docker.conf $DOCKER_PATH


RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
  && apt-get update \
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
  && docker-php-ext-install pdo pdo_pgsql pgsql \
  && pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug \
  && pecl install -o redis && docker-php-ext-enable redis \
  && docker-php-ext-install zip sockets bcmath mbstring \
  && pecl install amqp && docker-php-ext-enable amqp \
  && addgroup --gid $UID --system $NGINX_PHP_USER \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID $NGINX_PHP_USER \
  && sed -i -r "s/%REPLACE_USERNAME%/$NGINX_PHP_USER/g" $DOCKER_PATH \
  && rm -rf /tmp/pear

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

CMD ["php-fpm"]