FROM php:7.4-fpm-alpine

COPY . /app/

WORKDIR /app

COPY ./files/index.html /app/www/index.html

RUN set -ex && apk add -Ut git nginx \
&& mkdir -p /run/nginx \
&& mkdir -p /app/www \
&& chown -R www-data:www-data /app/www/

COPY ./config/nginx.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]