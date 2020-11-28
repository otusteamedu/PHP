```
# cd cd hw-1-3/task3/

docker build -t hw-1-3-task-3 .

docker run -it --rm hw-1-3-task-3 php -i | grep -E '^redis|^memcached|^http|^pdo_pgsql'
docker run -it --rm hw-1-3-task-3 composer --version

```
