<?php


namespace App\Shop\Factory;


use App\Shop\Burger;
use App\Shop\Decorators\BeefFood;
use App\Shop\Decorators\FishFood;
use App\Shop\Decorators\KitchenFood;

class BurgerFactory implements Interfaces\FastFoodFactory
{

    public function createKitchenFood(): KitchenFood
    {
        return new KitchenFood(new Burger());
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