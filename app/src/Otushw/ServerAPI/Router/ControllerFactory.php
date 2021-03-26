<?php

namespace Otushw\ServerAPI\Router;

use Otushw\Queue\QueueProducerInterface;
use Otushw\ServerAPI\Controllers\BaseController;

class ControllerFactory
{

    private string $controller;
    private string $action;
    private ?int $id;

    public function __construct(string $controller, string $action, ?int $id)
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->id = $id;
    }

    public function getController(QueueProducerInterface $queueProducer): BaseController
    {
        $class = $_ENV['controllers'] . '\\' . $this->controller;
        if (class_exists($class)) {
            return new $class($queueProducer);
        }
        // Exception
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getID(): ?int
    {
        return $this->id;
    }

}
