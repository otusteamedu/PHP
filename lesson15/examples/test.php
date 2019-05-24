#!/usr/bin/env php
<?php

define('APP_DIR', __DIR__ . '/..');
require APP_DIR . '/vendor/autoload.php';

use Otus\{EventManager, Event, EventItem};

$manager = new EventManager();

// Creating some Events, EventsItems and add it in redis
$event = new Event();
$eventItem = new EventItem($event);
$eventItem->setPriority(100);
$eventItem->setConditions(['color' => 'black', 'size' => 'M']);
$manager->addEventToList($eventItem);

$eventItem = new EventItem($event);
$eventItem->setPriority(200);
$eventItem->setConditions(['color' => 'black']);
$manager->addEventToList($eventItem);

$eventItem = new EventItem($event);
$eventItem->setPriority(90);
$eventItem->setConditions(['color' => 'red', 'size' => 'M']);
$manager->addEventToList($eventItem);

$events = $manager->getAllEventsByConditions(['color' => 'black']); //get 2 EventItems in $events

$event = $manager->getEventByConditions(['color' => 'black']); // get 1 EventItem in $event

$manager->clearData(); // clear all EventItems and their conditions from redis
