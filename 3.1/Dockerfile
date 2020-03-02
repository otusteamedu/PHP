FROM alpine:latest

RUN apk update && apk add php php7-dev wget autoconf make gcc g++ file php7-redis php7-json bash
RUN wget https://github.com/phpredis/phpredis/archive/master.zip -O phpredis.zip \
    && unzip -o phpredis.zip \
    && mv phpredis-* phpredis

RUN cd phpredis && phpize && ./configure --with-php-config=/usr/bin/php-config --disable-redis-session \
    && make >> make_output.txt && make install
RUN mkdir /etc/php7/mods-available && touch /etc/php7/mods-available/redis.ini && echo "extension=redis.so" > /etc/php7/mods-available/redis.ini
#RUN ln -s /etc/php7/mods-available/redis.ini /etc/php7/conf.d/redis.ini
RUN pwd
RUN php -i | grep redis