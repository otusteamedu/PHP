```
Docker php-fpm with packages
```

Commands:

    build:
    docker-compose up -d --build

remove:
    
    docker-compose stop && docker-compose rm -f

connect:

    winpty docker exec -it php bash
    winpty docker exec -it web bash
    
    docker-compose stop && docker-compose rm -f;docker-compose up -d --build;  docker-compose ps

 composer:
 
    composer install
    composer dump-autoload

 Install:
 
    winpty docker exec -it php bash
    composer install ruslangr/hw3
    or
    git clone https://github.com/notRuslan/dz3.git .
    
    