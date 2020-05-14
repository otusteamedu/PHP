FROM nginx:alpine
COPY default.conf /etc/nginx/conf.d/default.conf
COPY index.html /var/www/html/index.html
COPY default.css /var/www/html/default.css
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
