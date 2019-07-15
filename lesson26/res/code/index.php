<?php

define('APPLICATION_PATH', __DIR__);
include(APPLICATION_PATH . '/vendor/autoload.php');

use \Otus\Basic\{Request, Router};
use \Otus\Consumers\MessageConsumer;

$consumer = new MessageConsumer();
if (!$consumer->isRunning()) {
    $consumer->runScript();
}

$request = new Request();
Router::route($request->getPathInfo());

exit();