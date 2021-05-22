<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Decorator;

use App\Model\Product\Entity\Ingredient\IngredientInterface;
use App\Model\Product\Entity\Product\ProductInterface;
use App\Model\Product\Entity\Recipe\RecipeFactory;

class RecipeDecorator extends AbstractProductDecorator
{
    public function __construct(ProductInterface $product)
    {
        parent::__construct($product);

        $recipe = RecipeFactory::create($this->product->getName());

        /* @var IngredientInterface $ingredient */
        foreach ($recipe->getIngredients() as $ingredient) {
            $this->product->addIngredient($ingredient);
        }
    }
}