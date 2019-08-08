<?php

require './vendor/autoload.php';

use hw15\Worker;
use hw15\Event;

define('APP_DIR', __DIR__ . '.');

$data = [
    "{
        priority: 1000,
        conditions: 
            {
                param1 = 1
            },
        event: 
            {
                name: name,
                description: description,
            },
    },",
    "{
        priority: 2000,
        conditions: 
            {
                param1 = 2,
                param2 = 2,
            },
        event: 
            {
                name: name,
                description: description,
            },
    },",
    "{
        priority: 3000,
        conditions: 
            {
                param1 = 1,
                param2 = 2,
            },
        event: 
            {
                name: name,
                description: description,
            },
    },",
];

$worker = new Worker;

$event = new Event();

foreach ($data as $eventData) {

    $event = new Event();

    $event->loadFromJson($eventData);

    $worker->addEventToList($event);

}

$event = $worker->getEventByConditions("{param1 = 1,param2 = 2,},");

$worker->clearData();

