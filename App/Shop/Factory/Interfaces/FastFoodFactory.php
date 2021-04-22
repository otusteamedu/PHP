<?php


namespace App\Shop\Factory\Interfaces;


use App\Shop\Decorators\BeefFood;
use App\Shop\Decorators\FishFood;
use App\Shop\Decorators\KitchenFood;

interface FastFoodFactory
{

    public function createKitchenFood(): KitchenFood;

    public function createFishFood(): FishFood;

    public function createBeefFood(): BeefFood;

}