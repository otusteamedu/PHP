<?php


namespace App\Shop;


use App\Shop\Factory\Interfaces\FastFoodItem;
use App\Shop\Factory\Interfaces\Ingredients;

abstract class AbstractFastFood implements FastFoodItem
{
    private Ingredients $ingredients;

    public function __construct()
    {
        $this->ingredients = new \App\Shop\Factory\Ingredients();
    }

    public function ingredients(): Ingredients
    {
        return $this->ingredients;
    }
}