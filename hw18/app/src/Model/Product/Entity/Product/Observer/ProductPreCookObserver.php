<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Observer;

use App\Model\Product\Entity\Product\Events;
use App\Model\Product\Entity\Product\ProductInterface;
use App\Model\Product\Entity\Recipe\RecipeFactory;
use DomainException;

class ProductPreCookObserver implements ObserverInterface
{
    private RecipeFactory $recipeFactory;

    public function __construct(RecipeFactory $recipeFactory)
    {
        $this->recipeFactory = $recipeFactory;
    }

    public function getEventName(): string
    {
        return Events::EVENT__PRE_COOK;
    }

    public function handle(ObservableInterface $observable, string $eventName = ''): void
    {
        /* @var ProductInterface $observable */

        if ($eventName === $this->getEventName()) {
            $this->assertProductContainsRequiredIngredients($observable);
        }
    }

    private function assertProductContainsRequiredIngredients(ProductInterface $product): void
    {
        $standardRecipe = $this->recipeFactory->create($product->getName());

        if (!$product->areIngredientsExist($standardRecipe->getRequiredIngredients())) {
            throw new DomainException($product->getName() . ' не содержит обязательные ингредиенты');
        }
    }
}