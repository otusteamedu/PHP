FROM debian

RUN apt-get update

RUN apt-get install -y nginx

WORKDIR /var/www

COPY ./nginx/otus.loc.conf /etc/nginx/sites-enabled/otus.loc.conf

COPY ./src/index.html /var/www/html/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]