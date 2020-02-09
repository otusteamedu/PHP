<?php

use \App\Event;

$event = new Event();
$event->flushAll();

$event1 = new Event();
$event1->setName('event1');
$event1->setPriority('1000');
$event1->setConditions(['param1' => 1]);
$event1->save();

$event2 = new Event();
$event2->setName('event2');
$event2->setPriority('2000');
$event2->setConditions(['param1' => 2, 'param2' => 2]);
$event2->save();

$event3 = new Event();
$event3->setName('event3');
$event3->setPriority('3000');
$event3->setConditions(['param1' => 1, 'param2' => 2]);
$event3->save();

$event4 = new Event();
$event4->setName('event4');
$event4->setPriority('3000');
$event4->setConditions(['param2' => 2]);
$event4->save();

// event3, event4
print_r ($event->getPriorityEventByCondition(['param1' => 1, 'param2' => 2]));
