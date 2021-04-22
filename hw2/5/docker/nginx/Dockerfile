FROM debian

RUN apt-get update
RUN apt-get -y install nginx

ENV TZ=Europe/Kiev
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY /docker/nginx/dev.mysite.conf /etc/nginx/conf.d/default.conf