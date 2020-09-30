FROM nginx:stable
RUN set -x \
    && deluser www-data \
    && groupadd -g 500 -r www-data \
    && useradd -u 500 -g www-data www-data
CMD ["nginx", "-g", "daemon off;"]