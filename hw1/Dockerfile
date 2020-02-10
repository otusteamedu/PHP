FROM alpine

RUN apk update \
    && apk add nginx \
    && mkdir -p /run/nginx

WORKDIR /var/www

COPY ./conf/nginx/test.local.conf /etc/nginx/conf.d/default.conf
COPY ./files/index.html /var/www/test.local/index.html

EXPOSE 8080

CMD ["nginx", "-g", "daemon off;"]