FROM nginx:stable-alpine

LABEL maintainer="Alexandr Timofeev <tim31al@gmail.com>"

RUN apk update \
    && apk upgrade \
    && apk add --no-cache openssl \
    && apk add --no-cache bash

ARG UID
ARG GID
ARG USER
ARG GROUP

RUN addgroup -g ${GID} -S ${GROUP} \
    && adduser -u ${UID} -S -D -H ${USER} ${GROUP}

COPY nginx.conf /etc/nginx/
COPY conf.d/gzip.conf /etc/nginx/conf.d/
COPY sites-enabled/mysite.local.conf /etc/nginx/sites-enabled/

ADD startup.sh /usr/local/bin/startup.sh

RUN bash /usr/local/bin/startup.sh; \
    rm /etc/nginx/conf.d/default.conf

