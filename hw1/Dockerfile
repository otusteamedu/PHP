FROM alpine:latest

RUN apk update && apk add nginx

RUN mkdir -p /run/nginx && mkdir /var/www/mysite.local/

ENV TZ=Asia/Barnaul

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]