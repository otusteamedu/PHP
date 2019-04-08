#!/usr/bin/env sh

cd /app

composer install || exit 1

./vendor/bin/phpunit ./tests/ || exit 2

chmod +x ./calculator.php

trap "exit;" 1 2 3 15

while true; do
    sleep 10
done;