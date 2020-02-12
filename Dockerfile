FROM alpine:3.7

# update packages
RUN apk update

# install nginx
RUN apk add nginx

# https://github.com/gliderlabs/docker-alpine/issues/185#issuecomment-246595114
RUN mkdir -p /run/nginx

# turn off default conf to prevent 404
RUN mv /etc/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf.disabled

# copy site conf
COPY ./etc/hw1.local.conf /etc/nginx/conf.d/

# copy site index page
COPY ./files/index.html /var/www/hw1.local/

# set workdir
WORKDIR /var/www

# open 80 port
EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
