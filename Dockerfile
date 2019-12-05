FROM nginx:1.17.6-alpine

WORKDIR /etc/nginx/

COPY ./conf/nginx/hosts/hw2.local.conf /etc/nginx/sites-enabled/hw2.local.conf

COPY ./files/index.html /var/www/hw2.local/index.html

RUN ln -s /etc/nginx/sites-enabled/hw2.local.conf /etc/nginx/conf.d/hw2.local.conf