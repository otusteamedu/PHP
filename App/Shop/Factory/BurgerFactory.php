<?php


namespace App\Shop\Factory;


use App\Shop\Burger;
use App\Shop\Decorators\BeefFood;
use App\Shop\Decorators\FishFood;
use App\Shop\Decorators\ChickenFood;

class BurgerFactory implements Interfaces\FastFoodFactory
{

    public function createChickenFood(): ChickenFood
    {
        return new ChickenFood(new Burger());
    }

    public function createFishFood(): FishFood
    {
        return new FishFood(new Burger());
    }

    public function createBeefFood(): BeefFood
    {
        return new BeefFood(new Burger());
    }
}