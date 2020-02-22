FROM alpine
RUN apk update
RUN apk add  nginx
RUN mkdir -p /run/nginx
WORKDIR /var/www
RUN mkdir test && echo "hello from docker" > test/index.html
COPY my_site.conf /etc/nginx/conf.d/
EXPOSE 8080
CMD ["nginx", "-g", "daemon off;"]