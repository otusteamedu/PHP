FROM nginx:latest
MAINTAINER Irina Malovastaja <irina.malovastaja@yandex.ru>
ARG UID

COPY ./nginx.conf /etc/nginx/nginx.conf
COPY ./fastcgi_params /etc/nginx/fastcgi_params
COPY email_valid.conf /etc/nginx/conf.d/default.conf

RUN addgroup --gid $UID --system email_valid \
  && adduser --uid $UID --system --disabled-login --disabled-password --gid $UID email_valid

EXPOSE 80
CMD [ "nginx", "-g", "daemon off;" ]