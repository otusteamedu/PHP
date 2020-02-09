FROM debian

RUN apt-get update

RUN apt-get install -y nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./config/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./public/* /var/www/mysite.local/public/

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
