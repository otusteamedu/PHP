FROM debian

RUN apt-get update

RUN apt-get -y install nginx

ENV TZ=Europe/Kiev

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/

COPY nginx/dev.mysite.conf /etc/nginx/sites-available/dev.mysite.conf

COPY /1/hw-1-1/files/index.html /var/www/html/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]