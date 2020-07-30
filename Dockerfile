FROM ubuntu
RUN apt-get update
RUN apt-get install -y nginx
WORKDIR /var/www
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
