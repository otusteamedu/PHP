FROM nginx:stable-alpine

RUN addgroup nginx www-data

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./default.conf /etc/nginx/conf.d/default.conf
