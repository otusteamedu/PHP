FROM ubuntu:latest

RUN apt-get update && apt-get install -y nginx

ARG UID
ARG NGINX_PHP_USER

RUN addgroup --gid $UID --system $NGINX_PHP_USER \
    && adduser --uid $UID --system --disabled-login --disabled-password \
    --gid $UID \
    $NGINX_PHP_USER

RUN sed -i 's/user www-data;/user '$NGINX_PHP_USER';/' /etc/nginx/nginx.conf

CMD ["nginx", "-g", "daemon off;"]