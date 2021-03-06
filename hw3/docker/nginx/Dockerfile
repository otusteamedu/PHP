FROM ubuntu:latest  
RUN apt update && apt install -y \
        nginx \
        curl \
        wget \
        grep \
        nano \
        && apt clean
COPY ./hosts/mysite.local.conf /etc/nginx/sites-enabled/mysite.local.conf
WORKDIR /var/www  
VOLUME /data  
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]