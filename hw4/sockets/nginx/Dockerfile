FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
WORKDIR /var/www  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]