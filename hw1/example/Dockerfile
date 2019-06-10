
FROM debian

RUN apt-get  update

RUN apt-get install -y nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/schare/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

