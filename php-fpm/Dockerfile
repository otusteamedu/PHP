FROM crunchgeek/php-fpm:7.3-r5
RUN apt-get update
RUN addgroup --gid 3000 --system app && adduser --uid 3000 --system --disabled-login --disabled-password --gid 3000 app
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer global require laravel/installer
RUN echo "export PATH=$PATH:/root/.composer/vendor/bin" >> /root/.bashrc
