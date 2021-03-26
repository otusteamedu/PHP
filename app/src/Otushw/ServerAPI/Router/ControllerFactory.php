<?php

namespace Otushw\ServerAPI\Router;

use Otushw\Queue\QueueProducerInterface;
use Otushw\ServerAPI\Controllers\BaseController;
use Otushw\ServerAPI\Exception\ControllerFactoryException;

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
        throw new ControllerFactoryException("Controller ($this->controller) does not exist");
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
