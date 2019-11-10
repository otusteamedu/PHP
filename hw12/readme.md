#OTUS Homework #12 Solution 

#### How to run the project:

1. Copying environment configuration files: `cp .env.examle .env && cp phinx.yml.example phing.yml`
2. Running the Docker: `docker-compose up -d`
3. Installation Composer packages: `docker-compose exec php-cli composer install`
4. Running the database migrations: `docker-compose exec php-cli vendor/bin/phinx migrate`
5. Seeding the database: `docker-compose exec php-cli vendor/bin/phinx seed:run -s FilmSeeder -s GenreSeeder -s FilmGenreSeeder`
6. `docker-compose exec php-cli php index.php`