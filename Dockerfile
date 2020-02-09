FROM alpine:latest

RUN apk update && apk add nginx \
    && echo "pid /tmp/nginx.pid;" >> /etc/nginx/nginx.conf

COPY config/static-site.conf /etc/nginx/conf.d/
COPY data/index.html /var/www/staticsite/

RUN chown -R nginx:nginx /var/www/staticsite

CMD ["nginx", "-g", "daemon off;"]