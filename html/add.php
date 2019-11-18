<?php

if (!extension_loaded('Redis')) {
	die('The Redis extension is not loaded.');
}
if (empty($_POST)) {
	die('I need POST');
}

include 'classes/EventClass.php';

$event = new EventClass($_POST);

if ($event->addEvent()) {
	echo "added" . PHP_EOL;
} else {
	"not added" . PHP_EOL;
}