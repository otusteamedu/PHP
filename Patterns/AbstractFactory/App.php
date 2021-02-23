<?php

namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\Interface\TransportFactory;

class App
{
    private $factory;
    private $car;

    public function __construct(TransportFactory $factory)
    {
        $this->factory = $factory;
    }

    public function createTransport()
    {
        $this->car = $this->factory->createCar();
    }

    public function getTransport()
    {
        return $this->car;
    }

    public function forward()
    {
        $this->car->forward();
    }
}