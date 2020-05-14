FROM alpine

RUN apk update && apk upgrade && apk add nginx

COPY ./config/site.local.conf /etc/nginx/conf.d

COPY ./files/index.html /var/www/localhost/htdocs/index.html

CMD ["nginx", "-g", "pid /tmp/nginx.pid; daemon off;"]

