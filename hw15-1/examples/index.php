<?php

require_once '../vendor/autoload.php';

use TimGa\Redis\Event;
use TimGa\Redis\EventHandler;

$redisClient = new \Predis\Client(include 'config/redis_connection.php');
$eventHandler = new EventHandler($redisClient);

// configure events
$events[] = new Event(1000, ['one'], 'event:1');
$events[] = new Event(2000, ['two', 'two'], 'event:2');
$events[] = new Event(3000, ['one', 'two'], 'event:3');

// insert events into redis
foreach ($events as $event) {
    $eventHandler->insertEvent($event);
}

// find event by conditions
$eventHandler->findEventByConditions(['one', 'two']);  // returns 'event:3'
$eventHandler->findEventByConditions(['two', 'two']);  // returns 'event:2'
$eventHandler->findEventByConditions(['two', 'one']);  // returns 'no matches found'

// clean up
$eventHandler->cleanUp();
