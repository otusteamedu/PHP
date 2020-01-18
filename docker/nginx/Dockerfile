FROM nginx:1.17.2-alpine

RUN set -xe \
    && apk add --no-cache --virtual .build-deps \
        curl \
        gzip
COPY config/ /etc/nginx/


WORKDIR /var/www