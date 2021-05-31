<?php


namespace App\Shop\Factory;


use App\Shop\Decorators\BeefFood;
use App\Shop\Decorators\FishFood;
use App\Shop\Decorators\ChickenFood;
use App\Shop\Sandwich;

class SandwichFactory implements Interfaces\FastFoodFactory
{

    public function createChickenFood(): ChickenFood
    {
        return new ChickenFood(new Sandwich());
    }

    public function createFishFood(): FishFood
    {
        return new FishFood(new Sandwich());
    }

    public function createBeefFood(): BeefFood
    {
        return new BeefFood(new Sandwich());
    }
}