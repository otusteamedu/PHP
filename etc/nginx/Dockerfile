FROM nginx:1.17.6-alpine

MAINTAINER Eugene Vasiltsov

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/html
