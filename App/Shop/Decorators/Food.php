<?php


namespace App\Shop\Decorators;


use App\Shop\Factory\Interfaces\FastFoodItem;
use App\Shop\Factory\Interfaces\Ingredients;

class Food implements FastFoodItem
{
    private FastFoodItem $item;

    public function __construct(FastFoodItem $fastFoodItem)
    {
        $this->item = $fastFoodItem;
    }

    public function cook(): string
    {
        return $this->item->cook();
    }

    public function ingredients(): Ingredients
    {
        return $this->item->ingredients();
    }
}