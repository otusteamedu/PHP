FROM debian:latest

# Мета данные
LABEL version="1.0"
LABEL description="Nginx container"
LABEL maintainer = "Vladimir Valyakin"

ENV TZ=Europe/Moscow
ENV ADMIN="Vladimir"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update && apt install -y \
    nginx \
    libnginx-mod-http-lua

WORKDIR /var/www/html
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]