FROM nginx:1.16.1-alpine

RUN addgroup -g 1000 -S ruben
RUN adduser -u 1000 -S -G ruben ruben

RUN rm /etc/nginx/conf.d/default.conf
RUN rm /etc/nginx/nginx.conf

COPY default.conf.template /etc/nginx/conf.d
COPY nginx.conf /etc/nginx/nginx.conf

RUN touch /var/run/nginx.pid \
 && chown -Rf ruben:ruben \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /etc/nginx/conf.d \
    /var/log/nginx

USER ruben

CMD envsubst '$$SOCK' < /etc/nginx/conf.d/default.conf.template > /etc/nginx/conf.d/default.conf &&  nginx -g 'daemon off;'