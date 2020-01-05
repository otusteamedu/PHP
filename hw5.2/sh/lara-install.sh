#!/bin/bash

if [ ! -f /var/www/artisan ]
then
  composer create-project --prefer-dist laravel/laravel /var/www/
fi
