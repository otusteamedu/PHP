<?php

require '../vendor/autoload.php';

$client = new \Predis\Client(include '../settings/redis.php');

$factory = new \crazydope\events\EventFactory();
$event = $factory->build('test event 1', 100, ['1'=>'test']);
$event2 = $factory->build('test event 2', 200, ['1'=>'test']);
$event3 = $factory->build('test event 3', 100, ['1'=>'test','2'=>'test2']);

$eventList = new \crazydope\events\EventList($client);

$eventList->set($event)->set($event2)->set($event3);

$result = $eventList->getByCondition([1=>'test']); // return event2
var_dump($result);
$result = $eventList->getByCondition([2=>'test2']); // return null. Not all conditions are met
var_dump($result);
$result = $eventList->getByCondition([1=>'test',2=>'test2']); // return event3.
var_dump($result);
$eventList->clear(); //delete all events