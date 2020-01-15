<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use App\Application;
use App\EventHandler;
use App\Validators\EventValidator;

try
{
    $app = new Application();
    $validator = new EventValidator();
    $eventHandler = new EventHandler($app->getDb());
    $responseInfo = ['error' => null, 'success' => null];

    $event1 = '{"priority": 1000, "conditions": {"param1": 1}, "event": {"name": "Название события 1"}}';
    $event2 = '{"priority": 2000, "conditions": {"param1": 2, "param2": 2}, "event": {"name": "Название события 2"}}';
    $event3 = '{"priority": 3000, "conditions": {"param1": 1, "param2": 2}, "event": {"name": "Название события 3"}}';

    $key = $eventHandler->add($event1);
    $responseInfo['success'] .= "Событие добавлено с id: {$key}; ";
    $key = $eventHandler->add($event2);
    $responseInfo['success'] .= "Событие добавлено с id: {$key}; ";
    $key = $eventHandler->add($event3);
    $responseInfo['success'] .= "Событие добавлено с id: {$key}; ";

    $app->response->send($responseInfo);
}
catch (\Throwable $e)
{
    $app->response->send(['error' => $e->getMessage()], true);
}
