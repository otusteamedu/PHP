<?php

namespace Ozycast\App\DTO\Queue;

/**
 * Данные для отправки задания в очередь
 *
 * Class QueueDTO
 * @package Ozycast\App\DTO\Queue
 */
class QueueDTO
{
    private string $controller;
    private string $action;
    private array $params;

    public function __construct(
        $controller,
        $action,
        $params
    ) {

        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
    }

    public function toArray()
    {
        return [
            'controller' => $this->controller,
            'action' => $this->action,
            'params' => $this->params,
        ];
    }

    public function toString()
    {
        return json_encode($this->toArray());
    }
}