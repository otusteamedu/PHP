<?php
namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\Interface\Car;

class PassengerCar implements Car
{
    public function forward()
    {
        echo 'car forward';
    }
}