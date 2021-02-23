<?php
namespace Patterns\AbstractFactory;

use Patterns\AbstractFactory\Interface\Plane;

class PassengerPlane implements Plane
{
    public function forward()
    {
        echo 'plane forward';
    }
}