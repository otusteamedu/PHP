#!/bin/bash

/usr/local/sbin/php-fpm &
/usr/sbin/nginx -g "daemon off;"

