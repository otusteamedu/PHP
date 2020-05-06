FROM alpine:latest
COPY ./nginx/otus.conf /etc/nginx/conf.d/

RUN addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app \
 && apk update && apk add nginx \
 && echo "pid /tmp/nginx.pid;" >> /etc/nginx/nginx.conf \
 && sed -i "s/user nginx;/user app;/g" /etc/nginx/nginx.conf


CMD ["nginx", "-g", "daemon off;"]