<?php

require_once(__DIR__ . '/vendor/autoload.php');

use nvggit\hw26\RabbitWorker;

$worker = new RabbitWorker('custom_queue');
$worker->listen();
