FROM alpine:edge

# Timezone
ENV TIMEZONE Europe/Kiev
ENV PHP_MEMORY_LIMIT 1024M
ENV MAX_UPLOAD 128M
ENV PHP_MAX_FILE_UPLOAD 128M
ENV PHP_MAX_POST 128M

RUN set -ex \
#	&& addgroup -g 82 -S www-data \
#	&& adduser -u 82 -D -S -G www-data www-data \
	&& addgroup -g 1000 -S www-data \
	&& adduser -u 1000 -D -S -G www-data www-data \
	&& echo "@testing http://dl-4.alpinelinux.org/alpine/edge/testing" >> /etc/apk/repositories \
    && apk update \
    && apk upgrade \
    && apk add --update tzdata \
	&& cp /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
	&& echo "${TIMEZONE}" > /etc/timezone \
    && apk --update add --no-cache php7-fpm@testing php7-mcrypt@testing php7-openssl@testing php7-json@testing php7-mysqli@testing php7-session@testing php7-gd@testing php7-xmlreader@testing php7-xmlrpc@testing \
    php7-zip@testing php7-iconv@testing php7-curl@testing php7-zlib@testing php7@testing php7-ctype@testing php7-pgsql@testing php7-pdo_pgsql@testing bash rsync \
    && sed -i -e "s/;daemonize\s*=\s*yes/daemonize = no/g" /etc/php7/php-fpm.conf \
    && sed -i -e "s/listen\s*=\s*127.0.0.1:9000/listen = [::]:9000/g" /etc/php7/php-fpm.d/www.conf \
    && sed -i -e "s/;chdir\s*=\s*\/var\/www/chdir = \/usr\/src\/app/g" /etc/php7/php-fpm.d/www.conf \
    && sed -i -e "s/user\s*=\s*nobody/user = www-data/g" /etc/php7/php-fpm.d/www.conf \
    && sed -i -e "s/group\s*=\s*nobody/group = www-data/g" /etc/php7/php-fpm.d/www.conf \
    && sed -i -e "s/;clear_env\s*=\s*no/clear_env = no/g" /etc/php7/php-fpm.d/www.conf \
    && sed -i -e "s/;catch_workers_output\s*=\s*yes/catch_workers_output = yes/g" /etc/php7/php-fpm.d/www.conf \
    && sed -i "s|;date.timezone =.*|date.timezone = ${TIMEZONE}|" /etc/php7/php.ini \
    && sed -i "s|memory_limit =.*|memory_limit = ${PHP_MEMORY_LIMIT}|" /etc/php7/php.ini \
    && sed -i "s|upload_max_filesize =.*|upload_max_filesize = ${MAX_UPLOAD}|" /etc/php7/php.ini \
    && sed -i "s|max_file_uploads =.*|max_file_uploads = ${PHP_MAX_FILE_UPLOAD}|" /etc/php7/php.ini \
    && sed -i "s|post_max_size =.*|post_max_size = ${PHP_MAX_POST}|" /etc/php7/php.ini \
    && sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php7/php.ini \
    && apk del tzdata \
    && rm -rf /var/cache/apk/*

COPY data/myproject.com/docs /data/myproject.com/docs

RUN chown -R www-data:www-data /data/myproject.com/docs

EXPOSE 9000

CMD ["php-fpm7"]