```
# cd hw-2-1/task2

cp .env.example .env

docker-compose up -d

```

#test
run while sleep 0.5; do curl http://localhost:<APP_PORT1>; done

e.g.
```
while sleep 0.5; do curl http://localhost:81; done
```
