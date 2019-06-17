# HW13

Run docker-compose to start containers
```
docker-compose up -d
```

Inside php container
```
docker exec -it hw13-php bash
```

Run to migrate static data
```
php hw13.php migrate
```

Run to clear movie data from db
```
php hw13.php clear
```

Run to clear add movie data with attributes to db. Count from 0 to 10000000
```
php hw13.php add [count]
```

### Query PLAN
Query PLAN loged in query_plan.txt;