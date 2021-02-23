<?php
namespace Patterns\AbstractFactory\Interface;

interface TransportFactory
{
    public function createCar();
    public function createPlane();
}