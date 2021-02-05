FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
COPY ./conf/first-test.local.conf /etc/nginx/sites-enabled/first-test.local.conf
WORKDIR /data  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]