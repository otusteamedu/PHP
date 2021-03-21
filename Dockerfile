FROM nginx:1.19-alpine

WORKDIR /var/www

COPY nginx/default.conf /etc/nginx/conf.d

COPY public /var/www/public

EXPOSE 80