<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Decorator;

use App\Model\Product\Entity\Ingredient\Cheese;
use App\Model\Product\Entity\Product\ProductInterface;

class CheeseDecorator extends AbstractProductDecorator
{
    public function __construct(ProductInterface $product)
    {
        parent::__construct($product);

        $this->product->addIngredient(new Cheese(false));
    }
}