FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./config/docker-test.local.conf /etc/nginx/sites-enabled/docker-test.local.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]