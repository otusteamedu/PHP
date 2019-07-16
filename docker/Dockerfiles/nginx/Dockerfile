FROM nginx

ENV TIMEZONE Europe/Moscow
ENV PHP_MEMORY_LIMIT 1024M
ENV MAX_UPLOAD 128M
ENV PHP_MAX_FILE_UPLOAD 128
ENV PHP_MAX_POST 128M

RUN apt-get update && apt-get upgrade -y \
    && apt-get install -y software-properties-common apt-utils sudo mc mcedit wget nano git grep curl unzip zip tar net-tools yasm

