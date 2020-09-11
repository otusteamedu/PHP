#!/bin/sh

/usr/bin/composer install

php public/app.php server
