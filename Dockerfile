FROM nginx:alpine

COPY ./conf/rmaysak.loc.conf /etc/nginx/conf.d/rmaysak.loc.conf
COPY ./public/ /var/www/

CMD ["nginx", "-g", "daemon off;"]