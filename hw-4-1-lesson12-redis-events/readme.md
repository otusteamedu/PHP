```
# cd hw-4-1-lesson11-youtube/

cp .env.example .env
cp app/.env.example app/.env

docker-compose up -d && docker-compose exec app bash


# how to use app (examples):

- create event
POST /events
Body.form-data:
        [
            'action' => 'save',
            'name' => 'event name',
            'priority' => 1000,
            'conditions' => [
                'param1' => 1,
                'param2' => 2,
            ],
        ]
 
 - search of event with max priority & according to params       
GET /events?search&param1=1&param2=2

- clean storage
POST /events
Body.form-data:
        [
            'action' => 'clean', 
        ]
```
