FROM ubuntu:latest
RUN apt-get update
RUN apt-get install -y nginx
COPY default.conf /etc/nginx/sites-enabled/default
WORKDIR /data
VOLUME /data
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]