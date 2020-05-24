
FROM nginx:stable-alpine

RUN apk update

RUN apk add nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/


COPY ./conf/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-available/mysite.local.conf 

RUN mkdir /etc/nginx/sites-enabled/
RUN ln -s /etc/nginx/sites-available/mysite.local.conf  /etc/nginx/sites-enabled/

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]

