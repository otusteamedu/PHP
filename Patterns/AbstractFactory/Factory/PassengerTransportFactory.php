<?php
namespace Patterns\AbstractFactory\Factory;

use Patterns\AbstractFactory\Interface\TransportFactory;
use Patterns\AbstractFactory\PassengerCar;
use Patterns\AbstractFactory\PassengerPlane;



class PassengerTransportFactory implements TransportFactory
{
    public function createCar(): PassengerCar
    {
        return new PassengerCar();
    }

    public function createPlane(): PassengerPlane
    {
        return new PassengerPlane();
    }
}