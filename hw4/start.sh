#!/bin/sh
php test.php -mserver &
sleep 1
php test.php -mclient