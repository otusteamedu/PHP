FROM ubuntu:latest  
RUN apt-get update  
RUN apt-get install -y nginx  
RUN rm /etc/nginx/sites-enabled/default
COPY ./node.conf /etc/nginx/sites-enabled/node.conf
WORKDIR /app  
VOLUME /app  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]