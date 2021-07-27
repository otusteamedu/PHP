#let\'s assume that application is already installed, just pull changes
php artisan down # put application in maintenance mode
git pull origin master
composer update
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan migrate
php artisan up
php artisan queue:work
