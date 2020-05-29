FROM debian

RUN apt-get update

RUN apt-get install -y nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY ./nginx.conf /etc/nginx/sites-enabled/nginx.conf

WORKDIR /var/www

COPY ./files/index.html /var/hw1/index.html

EXPOSE 80

CMD [ "nginx","-g","daemon off;"]