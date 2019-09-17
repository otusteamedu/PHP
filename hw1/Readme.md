```
Static nginx site
```

Commands:

    build:
    docker-compose up -d --build

remove:
    
    docker-compose stop && docker-compose rm -f

connect:

    winpty docker exec -it mytest bash
    winpty docker exec -it mytest bash
    
    docker-compose stop && docker-compose rm -f;docker-compose up -d --build;  docker-compose ps

 
