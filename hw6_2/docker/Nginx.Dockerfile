FROM nginx
ADD ./nginx-config/default.conf /etc/nginx/conf.d/default.conf
#ADD ./config-nginx/nginx.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html