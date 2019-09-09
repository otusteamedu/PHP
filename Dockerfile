FROM ubuntu

RUN apt-get update

RUN apt-get install -y nginx

ENV TZ=Erope/Moscow

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY  ./nginx/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf


COPY   ./site/ /var/www/mysite.local/


EXPOSE 80

CMD [ "nginx","-g" ,"daemon off;"]