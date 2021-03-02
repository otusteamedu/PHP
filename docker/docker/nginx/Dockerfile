FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY hosts/hw.local.conf /etc/nginx/sites-enabled/hw.local.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]