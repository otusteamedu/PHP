FROM debian

RUN apt-get update

RUN apt-get install -y nginx

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./files/index.html /var/www/html/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
