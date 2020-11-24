FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./conf/nginx/hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 8080
CMD ["nginx", "-g", "daemon off;"]
