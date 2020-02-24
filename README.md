# Как использовать

```bash
docker-compose build
docker-compose -f docker-compose.prod.yml up -d
docker-compose exec nginx curl -v -X POST localhost -H 'Content-Type: application/x-www-form-urlencoded' -d 'string=()'
docker-compose down
```
