<?php
namespace Src\AbstractFactory;

class Hotdog implements AbstractFoodInterface
{
    public function getFoodName(): string
    {
        return 'Hotdog';
    }
}
