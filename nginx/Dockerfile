FROM alpine:latest

RUN addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app \
 && apk update && apk add nginx \
 && echo "pid /tmp/nginx.pid;" >> /etc/nginx/nginx.conf \
 && sed -i "s/user nginx;/user app;/g" /etc/nginx/nginx.conf

COPY otus.conf /etc/nginx/conf.d/

CMD ["nginx", "-g", "daemon off;"]