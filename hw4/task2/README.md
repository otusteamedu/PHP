## About

This is an example of docker configuration for laravel with Nginx + PHP-FPM + PostgreSQL

PHP-FPM container has all required libs from laravel documentation.

Each start PHP-FPM container will run composer install command, generate new app key, apply all migrations and run db seeding.

## Usage

```
git clone git@github.com:jekys13/docker-laravel.git
cd docker-laravel
docker-compose up -d
```

**Note:** First start can takes some time because of execution composer install command 