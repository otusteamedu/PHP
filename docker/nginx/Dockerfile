FROM nginx:1.19.0-alpine
 
RUN addgroup -g 1000 -S app
RUN adduser -u 1000 -S -G app app
 
COPY app.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf
 
RUN touch /var/run/nginx.pid \
 && chown -Rf app:app \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /var/log/nginx
 
USER app