<?php

require_once "vendor/autoload.php";

(new \App\Api\Api())->run(\App\Amqp\Rabbit::create());
