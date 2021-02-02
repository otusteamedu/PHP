FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./hosts/hw1.loc.conf /etc/nginx/sites-enabled/hw1.loc.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
