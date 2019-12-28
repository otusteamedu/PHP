FROM alpine

RUN apk update && apk upgrade --available && mkdir -p /run/nginx && apk add nginx

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
