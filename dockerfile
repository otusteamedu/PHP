FROM alpine

RUN apk update
RUN apk add nginx

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./test.loc /var/www/test.loc/
WORKDIR /var/www

EXPOSE 80:80

ENTRYPOINT ["nginx", "-g", "daemon off;"]