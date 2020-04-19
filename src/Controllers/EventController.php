<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Event;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController extends BaseController
{
    /**
     * Получить все доступные события.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $rows = Event::find();

        $events = [];
        foreach ($rows as $key => $row) {
            $events[$key] = json_decode($row, true);
        }

        return $this->getResponseJson($events);
    }

    /**
     * Добавить новое событие.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function addAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $priority = $data['priority'];
        $event = $data['event'];
        $conditions = $data['conditions'];

        $data = [
            'priority' => $priority,
            'conditions' => $conditions,
            'event' => $event,
        ];

        $inserted = Event::add($event['name'], $data);

        return $this->getResponseJson([
            'is_succeed' => (bool) $inserted,
            'inserted' => $inserted,
        ]);
    }

    /**
     * Удалить одно событие.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function removeOneAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();
        $name = $data['name'] ?? null;

        $deleted = Event::delete($name);

        return $this->getResponseJson([
            'is_succeed' => (bool) $deleted,
            'deleted' => $deleted,
        ]);
    }

    /**
     * Удалить все события.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function removeAllAction(ServerRequestInterface $request): ResponseInterface
    {
        $deleted = Event::deleteAll();

        return $this->getResponseJson([
            'is_succeed' => (bool) $deleted,
            'deleted' => $deleted,
        ]);
    }
}
