FROM nginx:latest

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf
WORKDIR /var/www

CMD nginx -g "daemon off;"