FROM php:7.4-cli
WORKDIR ./www
RUN apt update 
&& apt install -y git curl cron composer memcached libcurl
RUN pecl install redis-5.1.1 && pecl install pecl_http && docker-php-ext-enable redis memcached
RUN ./configure --with-pdo-pgsql
CMD [ "php", "./example.php", "daemon off;" ]
