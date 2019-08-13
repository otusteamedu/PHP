<?php
require_once "vendor/autoload.php";

Jekys\Event::dropAll();

$events = json_decode(file_get_contents('events.json'), true);

foreach ($events as $event) {
    Jekys\Event::create($event);
}

$testConditions = [
    [
        'param1' => 1,
        'param2' => 2
    ],
    [
        'param2' => 1
    ],
    [
        'param1' => 1
    ]
];

foreach ($testConditions as $conditions) {
    $event = Jekys\Event::getRelevant($conditions);
    var_dump($event);
}
