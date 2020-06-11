<?php

require_once "vendor/autoload.php";

$config = require_once("config/amqp.php");
$server = new \App\Queue\Workers\ServerWorker(new \App\Amqp\Rabbit($config));
$server->run();
