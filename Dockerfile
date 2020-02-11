FROM alpine:3.7

RUN apk update

RUN apk add nginx
# https://github.com/gliderlabs/docker-alpine/issues/185#issuecomment-246595114
RUN mkdir -p /run/nginx

COPY ./etc/hw1.local.conf /etc/nginx/sites-enabled/

COPY ./files/index.html /var/www/hw1.local/

WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
