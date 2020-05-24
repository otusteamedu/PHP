FROM nginx:alpine

COPY ./static/index.html /usr/share/nginx/html

EXPOSE 80
