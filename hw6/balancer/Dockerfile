FROM nginx:alpine

RUN addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app

COPY nginx.conf /etc/nginx/nginx.conf

RUN touch /var/run/nginx.pid \
 && chown -Rf app:app \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /var/log/nginx \
    /etc/nginx/conf.d/

EXPOSE 8080

USER app