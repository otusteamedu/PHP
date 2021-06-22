#!/bin/sh

cd /api
chown -R www-data:www-data storage/
sleep 15
php artisan migrate
php artisan queue:work