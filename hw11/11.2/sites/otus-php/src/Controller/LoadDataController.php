<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use App\Services\Redis\EventHandler;

class LoadDataController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var EventHandler
     */
    private $eventHandler;

    public function __construct(Application $app)
    {
        $this->eventHandler = new EventHandler($app->getDb());
        $this->app = $app;
    }

    /**
     * @throws \Exception
     */
    public function handler()
    {
        $events = [
            '{"priority": 1000, "conditions": {"param1": 1}, "event": {"name": "Название события 1"}}',
            '{"priority": 2000, "conditions": {"param1": 2, "param2": 2}, "event": {"name": "Название события 2"}}',
            '{"priority": 3000, "conditions": {"param1": 1, "param2": 2}, "event": {"name": "Название события 3"}}',
        ];

        $result['success'] = [];
        foreach ($events as $event) {
            $key = $this->eventHandler->add($event);
            $result['success'][] = "Событие добавлено с id: {$key}; ";
        }

        return new Response($result['success']);
    }
}



