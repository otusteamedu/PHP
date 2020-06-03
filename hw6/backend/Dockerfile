FROM php:7.3-fpm-alpine

RUN apk add --no-cache nginx \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN addgroup -g 3000 -S app \
 && adduser -u 3000 -S -D -G app app \
 && mkdir -p /sock /run/nginx/ \
 && touch /run/nginx/nginx.pid \
 && chown -Rf app:app /sock /run/nginx/nginx.pid /var/lib/nginx/ /var/lib/nginx/logs/ \
 && rm /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /usr/app

COPY nginx.conf /etc/nginx/nginx.conf
COPY www.conf /usr/local/etc/php-fpm.d/www.conf
COPY index.* composer.json start.sh ./
COPY src/ ./src/

RUN composer -a -- dump-autoload

USER app

CMD ["./start.sh"]