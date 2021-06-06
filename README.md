1) docker-compose up -d -build
2) docker-compose exec php-fpm php artisan migrate
3) docker-compose exec php-fpm php queue:work
4) localhost:7777/create-order