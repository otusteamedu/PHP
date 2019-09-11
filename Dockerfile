FROM ubuntu:latest
RUN apt-get update
RUN apt-get install -y nginx
RUN echo 'Goodbye cruel world, Hello containerized code' >/usr/share/nginx/html/index.html
EXPOSE 80