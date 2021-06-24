# Для начала указываем исходный образ, он будет использован как основа
FROM php:7.2-fpm

# RUN выполняет идущую за ней команду в контексте нашего образа.
# В данном случае мы установим некоторые зависимости и модули PHP.
# Для установки модулей используем команду docker-php-ext-install.
# На каждый RUN создается новый слой в образе, поэтому рекомендуется объединять команды.


RUN apt-get update && apt-get install -y \
	curl \
	wget \
	git \
	grep \
	libpq-dev \
	zip \
	unzip \
	libz-dev \
	libmemcached-dev \
	libcurl4-nss-dev \
	&& docker-php-ext-install pdo pdo_pgsql \
	&& pecl install redis memcached raphf propro \
	&& docker-php-ext-enable redis memcached raphf propro \
	&& pecl install pecl_http \
	&& docker-php-ext-enable http \
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Добавим свой php.ini, можем в нем определять свои значения конфига
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

# Указываем рабочую директорию для PHP
WORKDIR /var/www

# Запускаем контейнер
# Из документации: The main purpose of a CMD is to provide defaults for an executing container. These defaults can include an executable,
# or they can omit the executable, in which case you must specify an ENTRYPOINT instruction as well.
CMD ["php-fpm"]

