FROM nginx:stable-alpine

LABEL maintainer="Alexandr Timofeev <tim31al@gmail.com>"

RUN apk update && apk upgrade

COPY nginx.conf /etc/nginx/

RUN rm /etc/nginx/conf.d/default.conf

