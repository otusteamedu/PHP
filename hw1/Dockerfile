FROM alpine
RUN apk update
RUN apk add  nginx
RUN mkdir -p /run/nginx
WORKDIR /var/www
COPY my_site.conf /etc/nginx/sites-enabled/
COPY first_docker/* /var/www/test/
EXPOSE 8081
CMD ["nginx", "-g", "daemon off;"]
