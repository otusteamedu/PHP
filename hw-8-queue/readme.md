```
# cd hw-8-queue/

cp .env.example .env
cp app/.env.example app/.env

docker-compose up -d && docker-compose exec app bash


# how to use the app (examples):

- get messages from queue
php public/index.php queue receive

- put message into queue
POST /queue/send
    Body.form-data:
            [
                'message' => 'Test message!',
            ]
```
