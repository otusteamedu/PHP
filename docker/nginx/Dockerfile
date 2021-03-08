FROM ubuntu:latest

RUN apt-get update
RUN apt-get install -y nginx  
COPY ./hosts/hw.loc.conf /etc/nginx/sites-enabled/hw.loc.conf
RUN rm /etc/nginx/sites-enabled/default

WORKDIR /var/www/hw.loc
VOLUME /var/www/hw.loc
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
