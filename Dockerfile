#NGINX image

#VERSION Alpine image
ARG BASEIMAGE_VERION="3.10.3"
FROM alpine:${BASEIMAGE_VERION} as alpine-nginx

RUN apk update --no-cache && \
    mkdir -p /run/nginx && \
    apk add --no-cache nginx tzdata

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

STOPSIGNAL SIGTERM

ENTRYPOINT ["nginx", "-g", "daemon off;"]
