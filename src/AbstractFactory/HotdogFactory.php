<?php


namespace Src\AbstractFactory;


class HotdogFactory implements FoodFactory
{

    public function cookFood(): AbstractFood
    {
        return new Hotdog();
    }
}