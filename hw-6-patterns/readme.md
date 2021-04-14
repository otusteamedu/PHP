```
# cd hw-6-patterns/

cp .env.example .env

docker-compose up -d

docker-compose exec app composer install

run migration - http://192.168.39.3/database/migrations/Article.php

after: http://192.168.39.3

in result you will see like demo.png
```
