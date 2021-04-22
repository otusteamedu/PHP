<?php


namespace Src\AbstractFactory;


class Sandwich extends BaseMeal
{

    public function getFoodName(): string
    {
        return 'Sandwich';
    }
}