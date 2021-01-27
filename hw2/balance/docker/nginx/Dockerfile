FROM nginx:latest
MAINTAINER Irina Malovastaja <irina.malovastaja@yandex.ru>

#COPY ./nginx.conf /etc/nginx/nginx.conf
#COPY ./fastcgi_params /etc/nginx/fastcgi_params
COPY ./balance.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD [ "nginx", "-g", "daemon off;" ]