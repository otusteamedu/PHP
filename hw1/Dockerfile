FROM alpine

RUN apk update && apk upgrade && apk add nginx

#ENV TZ=Europe/Moscow
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./config/site.local.conf /etc/nginx/conf.d
#COPY ./config/custom.conf /etc/nginx/conf.d/default.conf

COPY ./files/index.html /var/www/localhost/htdocs/index.html

CMD ["nginx", "-g", "pid /tmp/nginx.pid; daemon off;"]

