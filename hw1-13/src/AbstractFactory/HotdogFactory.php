<?php
namespace Src\AbstractFactory;


class HotdogFactory implements AbstractFoodFactory
{
    public function cookFood() : AbstractFoodInterface
    {
        return new Hotdog();
    }
}