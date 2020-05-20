FROM nginx:mainline-alpine

RUN set -ex \
    #&& addgroup -g 82 -S www-data \
    #&& adduser -u 82 -D -S -G www-data www-data \
    adduser -D -H -u 1000 -s /bin/bash www-data -G www-data \
    && mkdir -p /etc/pki/nginx/ \
    && apk update \
    && apk --no-cache add --update openssl \
    #&& openssl dhparam -out /etc/pki/nginx/dhparams.pem 4096 \
    && openssl dhparam -dsaparam -out /etc/pki/nginx/dhparams.pem 4096 \
    && sed -i -e 's/user\s*nginx;/user  www-data www-data;/g' /etc/nginx/nginx.conf \
    && sed -i -e 's/worker_processes\s*1;/worker_processes  auto;/g' /etc/nginx/nginx.conf \
    && rm -rf /var/cache/apk/*

COPY conf/myproject.com /etc/nginx/conf.d/myproject.com.conf