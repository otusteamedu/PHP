FROM nginx
ADD ./config-nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html

