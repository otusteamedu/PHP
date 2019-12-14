FROM alpine

RUN apk update && \
    apk add nginx && \
    mkdir -p /run/nginx

COPY ./code /var/www/code
COPY ./nginx/ /etc/nginx/conf.d

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]