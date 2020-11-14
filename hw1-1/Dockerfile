FROM debian:latest

MAINTAINER Irina Malovastaja <irina.malovastaja@yandex.ru>

RUN apt-get update 
RUN apt-get install -y nginx
ENV TZ=Europe/Moscow
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
COPY ./docker-site.conf /etc/nginx/sites-enabled/docker-site.conf
COPY ./index.html /var/www/docker/docker-site.ikm/index.html
RUN ln -s /etc/nginx/sites-enabled/docker-site.conf /etc/nginx/sites-available/docker-site.conf
#RUN mkdir logs
WORKDIR /var/www/docker
VOLUME /var/www/docker
EXPOSE 80
CMD [ "nginx", "-g", "daemon off;" ]
