FROM ubuntu

RUN apt-get update && apt-get install -y nginx

ENV TX=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TX /etc/localtime && echo $TX > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./code/index.html ./mysite.local/index.html

COPY ./code/info.html ./mysite.local/info.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
