#NGINX image

#VERSION Alpine image
ARG BASEIMAGE_VERION="3.10.3"
FROM alpine:${BASEIMAGE_VERION} as alpine-nginx

ENV TZ=Europe/Moscow

RUN apk update && \
    apk upgrade --available && \
    mkdir -p /run/nginx && \
    apk add --no-cache nginx tzdata && \
    rm -rf /var/cache/apk/*

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/conf.d/mysite.local.conf

COPY ./files/index.html /var/www/mysite.local/index.html

EXPOSE 80

STOPSIGNAL SIGTERM

ENTRYPOINT ["nginx", "-g", "daemon off;"]
