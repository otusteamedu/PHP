ARG PHP_VERSION
FROM php:${PHP_VERSION}-fpm
ARG PHP_ERROR_LOG_PATH
ARG X_DEBUG
ARG X_DEBUG_ERROR_LOG_PATH
ARG MEMPROF_LOG_PATH

# Мета данные
LABEL version="1.0"
LABEL description="PHP-${PHP_VERSION} container"
LABEL maintainer = "Vladimir Valyakin"
ENV TZ=${TIMEZONE}
ENV ADMIN="Vladimir"
ENV MEMPROF_LOG_PATH=${MEMPROF_LOG_PATH}

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    # ставим необходимые для нормальной работы модули
    && apt update && apt install -y \
    curl \
    wget \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    libmcrypt-dev \
    libjudy-dev \
    libmemcached11 \
    libmemcachedutil2 \
    libmemcached-dev \
    libz-dev \
    libpq-dev \
    nodejs \
    && docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && pecl install xdebug \
    redis \
    memcache \
    memprof \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable redis \
    && docker-php-ext-enable memcache \
    && docker-php-ext-install opcache \
    # модуль для работы с сокетами
    && docker-php-ext-install sockets \
    && docker-php-ext-enable memprof \
    && docker-php-ext-install pdo \
    pgsql pdo_pgsql \
    && touch /tmp/profile.heap
# копирование подготовленного php.ini
COPY ./conf/php/php.ini /usr/local/etc/php/php.ini
# копирование подготовленных настроек для записи сессий в файл
COPY ./conf/php/session/php.ini-session-file /usr/local/etc/php/php.ini-session-file
# копирование подготовленных настроек для записи сессий в memcached
COPY ./conf/php/session/php.ini-session-memcache /usr/local/etc/php/php.ini-session-memcache
# копирование подготовленного xdebug.ini
COPY ./conf/X-Debug/docker-php-ext-xdebug.ini /usr/local/etc/php/docker-php-ext-xdebug.ini
# копирование подготовленного memcached.ini
COPY ./conf/memcached/docker-php-ext-memcache.ini /usr/local/etc/php/docker-php-ext-memcache.ini
# копирование конфигурационного файла для работы через сокет
COPY ./conf/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
# Если установлен параметр X_DEBUG, то копируем настройки x-debug
RUN if [ ${X_DEBUG} = true ]; then \
 mv /usr/local/etc/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
fi
RUN if [ ${X_DEBUG} = 1 ]; then \
 mv /usr/local/etc/php/docker-php-ext-xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini ; \
fi
# Если установлен параметр MEMCACHED_USE_SESSION, то копируем настройки memcached
RUN if [ ${MEMCACHED_USE_SESSION} = 1 ]; then \
 cat /usr/local/etc/php/php.ini-session-memcache >> /usr/local/etc/php/php.ini ; \
else  \
 cat /usr/local/etc/php/php.ini-session-file >> /usr/local/etc/php/php.ini ; \
fi
# Если установлен параметр MEMCACHED_CLUSTER, то копируем настройки memcached
RUN if [ ${MEMCACHED_CLUSTER} = true ]; then \
 mv /usr/local/etc/php/docker-php-ext-memcache.ini /usr/local/etc/php/conf.d/docker-php-ext-memcache.ini ; \
fi
RUN if [ ${MEMCACHED_CLUSTER} = 1 ]; then \
 mv /usr/local/etc/php/docker-php-ext-memcache.ini /usr/local/etc/php/conf.d/docker-php-ext-memcache.ini ; \
fi
# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Устанавливаем Npm
RUN curl -L https://npmjs.org/install.sh | sh
# устанавливаем рабочую директорию
WORKDIR /var/www/html
# WORKDIR /usr/local/etc
VOLUME /var/www/html
