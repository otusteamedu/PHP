<?php

require_once(__DIR__ . '/vendor/autoload.php');

use nvggit\hw26\rabbit\RabbitWorker;

$worker = new RabbitWorker('tasks_for_frogs');
$worker->listen();
