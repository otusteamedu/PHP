FROM nginx:latest

RUN apt-get update

RUN yes "" | openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout /etc/ssl/private/nginx-selfsigned.key \
    -out /etc/ssl/certs/nginx-selfsigned.crt

CMD ["nginx", "-g", "daemon off;"]