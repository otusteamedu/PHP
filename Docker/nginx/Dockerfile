FROM ubuntu:latest

# Мета данные
LABEL version="1.0"
LABEL description="Nginx container"
LABEL maintainer = "Vladimir Valyakin"

ENV TZ=Europe/Moscow
ENV ADMIN="Vladimir"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update && apt install -y \
    mc \
    nginx

# копирование файлов конфигурации для доступных сайтов внутрь контейнера
# COPY ./hosts/application.loc.conf /etc/nginx/sites-enabled/application.loc.conf
# COPY ./hosts/otus.loc.conf /etc/nginx/sites-enabled/otus.loc.conf

WORKDIR /var/www/html
VOLUME /var/www/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]