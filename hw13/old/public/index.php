<?php

require_once "../vendor/autoload.php";


use RedisApp\View;
use RedisApp\Controller;

$run = new Controller();
$run->run();

$eventToPrint = new View();
$eventToPrint->view();

echo "<pre>";
print_r ($eventToPrint->getEv1()); // event1
echo PHP_EOL;
echo PHP_EOL;
print_r ($eventToPrint->getEv2()); // event 3
echo "<br>";
echo "</pre>";