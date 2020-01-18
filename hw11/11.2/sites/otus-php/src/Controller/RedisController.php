<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use App\Services\Redis\EventHandler;

class RedisController
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
    public function addEvent()
    {
        $newEvent = $this->app->request->get('event');

        $key = $this->eventHandler->add($newEvent);
        $result['success'] = "Событие добавлено с id: {$key}; ";

        return new Response($result);
    }

    /**
     * @throws \Exception
     */
    public function queryEvent()
    {
        $userQuery = $this->app->request->get('query');

        $eventName = $this->eventHandler->query($userQuery);
        $result['success'] = "Подходящее событие '{$eventName}' отправлено; ";

        return new Response($result);
    }

    /**
     * @throws \Exception
     */
    public function dropEvents()
    {
        $this->eventHandler->dropEvents();
        $result['success'] = "Доступные события удалены; ";

        return new Response($result);
    }
}



