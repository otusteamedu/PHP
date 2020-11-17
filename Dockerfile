FROM nginx

COPY static.conf /etc/nginx/conf.d/static.conf

COPY public /srv/app/public
