FROM ubuntu:latest
RUN apt-get update &&  apt-get install -y nginx
COPY ./conf/nginx/hosts/otus-docker.test.conf /etc/nginx/sites-enabled/otus-docker.test.conf
WORKDIR /data
VOLUME /data
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
