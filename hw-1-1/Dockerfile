FROM ubuntu:latest
RUN apt-get update &&  apt-get install -y nginx
COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
WORKDIR /data
VOLUME /data
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
