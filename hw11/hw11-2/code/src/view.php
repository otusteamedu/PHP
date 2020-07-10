<?php

use RedisApp\EventController;

$eventToPrint = new EventController();

print_r ($eventToPrint->getBestEventByConditions(['param1' => 1])); // event1
echo "<br>";
print_r ($eventToPrint->getBestEventByConditions(['param1' => 1, 'param2' => 1])); // event 3
echo "<br>";