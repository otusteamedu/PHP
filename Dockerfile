FROM php:7.4-fpm-alpine

RUN addgroup -g 3000 app && adduser --uid 3000 -G app -D app

ARG DEPS_PHP="xdebug ast opcache pdo_pgsql"
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod u+x /usr/local/bin/install-php-extensions && sync && install-php-extensions $DEPS_PHP \
    && rm /usr/local/etc/php/conf.d/*xdebug.ini \
    && mv /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /usr/local/etc/php-fpm.d
COPY ./docker/app/conf/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/

COPY ./docker/app/conf/php/custom.ini /usr/local/etc/php/conf.d/

RUN mkdir /socks && chown app:app /socks

WORKDIR /app
RUN chown app:app /app

USER app
RUN mkdir /home/app/.opcache \
    && echo 'alias c="composer"' >> /home/app/.profile \
    && echo 'alias l="ls -lah"' >> /home/app/.profile

COPY --chown=app:app . .
RUN find /app -type d -print0 | xargs -t -0 -P 4 chmod 0755 > /dev/null 2>&1 \
    && find /app -type f -print0 | xargs -t -0 -P 4 chmod 0644 > /dev/null 2>&1

#RUN composer install --no-cache --no-dev
