```
# Terminal 1
# cd hw-2-1/task2/
docker-compose up -d
docker-compose exec php_fpm_service bash

cd public
php index.php server

# Terminal 2
# cd hw-2-1/task2/
docker-compose exec php_fpm_service bash

cd public
php index.php client

```
