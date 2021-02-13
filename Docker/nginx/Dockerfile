FROM ubuntu:latest
RUN apt-get update
RUN apt-get install -y nginx
COPY hosts/otusdocker.loc.conf /etc/nginx/sites-enabled/otusdocker.loc.conf
WORKDIR /data
VOLUME /data
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
