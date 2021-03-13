```
# cd hw-4-1-lesson11-youtube/

cp .env.example .env
cp app/.env.example app/.env

docker-compose up -d && docker-compose exec app bash


# how tonuse app (examples):

## save channels
php public/index.php explorer youtube channel save UCgPaqaEyKcQGk8jqKv2ctKg
php public/index.php explorer youtube channel save UC6eMRqZWwSBYS6IlVYD7dwQ
php public/index.php explorer youtube channel save UCnEEkiWWRG5mfgEN3UE7Rjg
php public/index.php explorer youtube channel save UCT9uh07OtVk9heoKwDdqhHg
php public/index.php explorer youtube channel save UC9O8BJRZn3GhtCSGNfnO9Xg

## list of channels
php public/index.php explorer youtube channel report

## top
php public/index.php explorer youtube channel top 3

## update-statistic (spider)
php public/index.php explorer youtube channel update-list

# list of videos
php public/index.php explorer youtube video report
```
