FROM debian

RUN apt-get update

RUN apt-get install -y nginx

ENV TZ=Europe/Moscow

WORKDIR /var/www

COPY ./hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
