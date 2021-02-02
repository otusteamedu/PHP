FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./hosts/otus-docker.conf /etc/nginx/sites-enabled/otus-docker.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
