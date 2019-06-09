<?php

include_once __DIR__ . '/../vendor/autoload.php';

use App\Event;
use App\RedisStore;

$event1 = new Event('event1', ['param1' => 1], 1000);
$event2 = new Event('event2', ['param1' => 1, 'param2' => 2], 2000);
$event3 = new Event('event3', ['param1' => 1, 'param2' => 2], 3000);

$redisStore = new RedisStore();

$redisStore->add($event1);
$redisStore->add($event2);
$redisStore->add($event3);


$requestCondition = ['param1' => 1, 'param2' => 2];
echo 'result: ' . PHP_EOL;
var_dump($redisStore->getRelevant($requestCondition));

$redisStore->clearAll();
