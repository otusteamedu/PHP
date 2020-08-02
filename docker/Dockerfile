FROM debian

RUN apt-get update
RUN apt-get install -y nginx

RUN rm -rf /etc/nginx/sites-enabled/*

ADD ./nginx_conf/hello.conf /etc/nginx/sites-available/hello.conf

RUN ln -s /etc/nginx/sites-available/hello.conf /etc/nginx/sites-enabled/hello.conf

ADD ./projects/site/index.html /var/www/hello/index.html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]