#!/bin/sh

/usr/bin/composer install

php-fpm --nodaemonize
