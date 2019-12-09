# OTUS Homework 11.2 Solution

### Requirements
- Docker CE

### Deploy
`docker-compose run -d --build`

`docker-compose exec php-cli composer install`

`cp .env.example .env`

`docker-compose exec php-cli php artisan key-generate`

`docker-compose exec nodejs npm install`

`docker-compose exec nodejs npm run prod`

### Usage
Open [http://localhost:8082](http://localhost:8082) in your browser.
