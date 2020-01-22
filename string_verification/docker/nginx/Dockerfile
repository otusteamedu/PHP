FROM nginx:1.15.8-alpine
 
RUN addgroup -g 1000 -S ruben
RUN adduser -u 1000 -S -G ruben ruben
 
COPY app.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf
 
RUN touch /var/run/nginx.pid \
 && chown -Rf ruben:ruben \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /var/log/nginx
 
USER ruben
