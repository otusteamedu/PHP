FROM debian

RUN apt-get update

RUN apt-get install -y nginx

WORKDIR /var/www

COPY ./hm1.otus-lessons.com.conf /etc/nginx/sites-enabled/hm1.otus-lessons.com.conf

COPY ./www-data/index.html /var/www/hm1/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]