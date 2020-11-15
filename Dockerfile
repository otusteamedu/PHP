FROM nginx:1.18.0-alpine
COPY conf/nginx/conf.d/otus-app.local.conf /etc/nginx/conf.d/otus-app.local.conf
COPY static /var/www/otus-app.local