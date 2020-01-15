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

    if ($app->request->has('add_event')) {
        $newEvent = $app->request->get('add_event');
        $key = $eventHandler->add($newEvent);
        $responseInfo['success'] .= "Событие добавлено с id: {$key}; ";
    }

    if ($app->request->has('query')) {
        $userQuery = $app->request->get('query');
        $eventName = $eventHandler->query($userQuery);
        $responseInfo['success'] .= "Подходящее событие {$eventName} отправлено; ";
    }

    if ($app->request->isTrue('drop_events')) {
        $eventHandler->dropEvents();
        $responseInfo['success'] .= "Доступные события удалены; ";
    }

    $app->response->send($responseInfo);
}
catch (\Throwable $e)
{
    $app->response->send(['error' => $e->getMessage()]);
}
