<?php

require_once "vendor/autoload.php";

$server = new \App\Queue\Workers\ServerWorker(\App\Amqp\Rabbit::create());
$server->run();
