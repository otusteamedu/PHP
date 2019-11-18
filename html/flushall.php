<?php

if (!extension_loaded('Redis')) {
	die('The Redis extension is not loaded.');
}

include 'classes/EventClass.php';

$event = new EventClass($_POST);
$event->flushall();