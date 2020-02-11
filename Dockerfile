FROM nginx:stable-alpine
WORKDIR /app

COPY ./conf/nginx.conf /etc/nginx/

ARG DEPS="npm"
COPY . /build
RUN set -ex \
    && apk add --no-cache --virtual .deps $DEPS \
    && cd /build \
    && npm install --no-cache \
    && npm audit fix \
    && npm run docs:build \
    && mv /build/docs/.vuepress/dist/* /app \
    && rm -rf /build \
    && apk del --no-cache .deps
