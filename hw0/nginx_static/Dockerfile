FROM nginx:latest

COPY app.local.conf /etc/nginx/conf.d/app.local.conf
COPY app /var/www/app

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]