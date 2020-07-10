<?php

use RedisApp\EventModel;

$event = new EventModel();
$event->flushAll();

$event1 = new EventModel();
$event1->setName('event1');
$event1->setPriority('1000');
$event1->setConditions(['param1' => 1]);
$event1->addHashToRedis();

$event2 = new EventModel();
$event2->setName('event2');
$event2->setPriority('2000');
$event2->setConditions(['param1' => 2, 'param2' => 2]);
$event2->addHashToRedis();

$event3 = new EventModel();
$event3->setName('event3');
$event3->setPriority('3000');
$event3->setConditions(['param1' => 1, 'param2' => 1]);
$event3->addHashToRedis();

