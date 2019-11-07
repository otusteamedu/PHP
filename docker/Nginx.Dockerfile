FROM nginx
ADD ./config-nginx/nginx.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html

