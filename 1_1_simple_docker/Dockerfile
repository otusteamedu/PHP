FROM debian

RUN apt-get update

RUN apt-get install -y nginx

ENV TZ=Europe/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf

COPY ./app /var/www/web

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]