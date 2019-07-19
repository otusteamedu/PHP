# Redis

### Installing

Composer install

### Example

See: `examples/index.php`

### How to

Configure redis in:

`config/redis_connection.php`

Connect to redis:

`$redisClient = new \Predis\Client(include 'config/redis_connection.php');`

Create event handler:

`$eventHandler = new EventHandler($redisClient);`

Create event:

`$event = new Event(int $priority, array $conditions, string $event_name);`

Insert event into Redis:

`$eventHandler->insertEvent($event);`

Search event by conditions:

`$eventHandler->findEventByConditions(array $conditions);`

Clean up events from Redis:

`$eventHandler->cleanUp();`