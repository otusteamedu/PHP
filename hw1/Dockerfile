FROM debian

RUN apt-get update

RUN apt-get install -y nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/ushakov
COPY ./docker/ushakov.local.conf /etc/nginx/sites-enabled/ushakov.local.conf
COPY ./src /var/www/ushakov

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
