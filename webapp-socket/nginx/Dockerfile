FROM nginx:1.15.8-alpine

RUN addgroup -g 3000 -S astrviktor
RUN adduser -u 3000 -S -G astrviktor astrviktor

COPY app.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf

RUN touch /var/run/nginx.pid \
    && chown -Rf astrviktor:astrviktor \
    /var/run/nginx.pid \
    /var/cache/nginx \
    /var/log/nginx

USER astrviktor
