<?php

namespace App\Shop\Adapters;

use App\Shop\Factory\Interfaces\FastFoodItem;
use App\Shop\Factory\Interfaces\Ingredients;
use App\Shop\IceCream;

class IceCreamAdapter implements FastFoodItem
{
    private Ingredients $ingredients;
    private IceCream $item;

    public function __construct(IceCream $iceCream)
    {
        $this->ingredients = new IceCreateIngredientsAdapter($iceCream);
        $this->item = $iceCream;
    }

    public function cook(): string
    {
        return 'Made ice-cream with ' . implode(', ', $this->ingredients()->getAll());
    }


    public function ingredients(): Ingredients
    {
        return $this->ingredients;
    }
}