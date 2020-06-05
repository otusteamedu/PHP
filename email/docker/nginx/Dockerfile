FROM nginx:stable-alpine

ARG UID
RUN addgroup -g $UID -S app \
  && adduser -u $UID -S -D -G app app

COPY ./default.conf /etc/nginx/conf.d/default.conf
COPY ./nginx.conf /etc/nginx/nginx.conf

