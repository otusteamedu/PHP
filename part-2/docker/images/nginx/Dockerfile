FROM nginx:alpine

ARG UID
RUN addgroup -g $UID -S app \
    && adduser -u $UID -S -s /usr/sbin/nologin -D -G app app

WORKDIR /app

CMD ["nginx", "-g", "daemon off;"]