#!/bin/sh

php artisan migrate:fresh --seed
chown -R www-data:www-data storage/
php artisan queue:work