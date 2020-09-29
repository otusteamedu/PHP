FROM php:7.4-fpm
RUN apt-get update && apt-get install -qy --no-install-recommends \
	libz-dev \
	libmemcached-dev \
	libevent-dev \
	libcurl4-openssl-dev \
	openssl \
	libssh-dev \
	libpq-dev \
	git \
	curl \
	wget \
	grep \
	&& pecl install redis \
	&& pecl install memcached \
	&& pecl install raphf \
	&& pecl install propro \
	&& docker-php-ext-enable raphf \
	&& docker-php-ext-enable propro \
	&& pecl install pecl_http \
	&& docker-php-ext-install pdo \
	&& docker-php-ext-install pdo_pgsql \
	&& curl -sS https://getcomposer.org/installer | php -- \
        --filename=composer \
        --install-dir=/usr/local/bin && \
        echo "alias composer='composer'" >> /root/.bashrc && \
        composer -V
