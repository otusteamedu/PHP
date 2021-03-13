FROM ubuntu:latest

RUN apt-get update
RUN apt-get install -y nginx net-tools telnet
COPY ./nginx/hosts/hw.loc.conf /etc/nginx/sites-enabled/hw.loc.conf
COPY ./socket/php-fpm.sock /var/run/php-fpm/php-fpm.sock
RUN rm /etc/nginx/sites-enabled/default

WORKDIR /var/www/hw.loc
VOLUME /var/www/hw.loc
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
