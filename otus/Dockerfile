FROM php:7.1-fpm
RUN apt-get update
RUN apt-get install -y bc
WORKDIR /var/www/html
ADD ./www /var/www/html
EXPOSE 9000
