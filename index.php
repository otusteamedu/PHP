<?php
require_once 'vendor/autoload.php';

use AlexRedis\Report;

$report = new Report();

$events = [
    [
        'priority' => 1000,
        'conditions' => [
            'param1' => 1,
            'param2' => 2
        ],
        'event' => [
            'description' => 'just another event...'
        ]
    ],
    [
        'priority' => 2000,
        'conditions' => [
            'param1' => 2,
            'param2' => 2
        ],
        'event' => [
            'description' => 'just another event...'
        ]
    ],
    [
        'priority' => 3000,
        'conditions' => [
            'param1' => 1,
            'param2' => 2
        ],
        'event' => [
            'description' => 'just another event...'
        ]
    ],

];


//add events
foreach ($events as $event) {
    $report->addEvent($event);
}

//check that we add 3rd event
var_dump($report->getByKey('event3:priority', ['priority']));

//find event by parameters
$vent = $report->getEvent(['param1' => 1, 'param2' => 2]);

//delete all events
$report->deleteEvents();


