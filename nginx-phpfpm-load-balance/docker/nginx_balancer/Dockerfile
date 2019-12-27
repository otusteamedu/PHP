FROM nginx:1.16.1-alpine

RUN addgroup -g 1000 -S ruben
RUN adduser -u 1000 -S -G ruben ruben
 
COPY nginx.conf /etc/nginx/conf.d/default.conf

RUN touch /var/run/nginx.pid \
 && chown -Rf ruben:ruben \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /var/log/nginx
 
USER ruben
