<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Decorator;

use App\Model\Product\Entity\Ingredient\Onion;
use App\Model\Product\Entity\Product\ProductInterface;

class OnionDecorator extends AbstractProductDecorator
{
    public function __construct(ProductInterface $product)
    {
        parent::__construct($product);

        $this->product->addIngredient(new Onion(false));
    }
}