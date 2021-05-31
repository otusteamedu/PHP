<?php


namespace App\Shop\Factory\Interfaces;


use App\Shop\Decorators\BeefFood;
use App\Shop\Decorators\FishFood;
use App\Shop\Decorators\ChickenFood;

interface FastFoodFactory
{

    public function createChickenFood(): ChickenFood;

    public function createFishFood(): FishFood;

    public function createBeefFood(): BeefFood;

}