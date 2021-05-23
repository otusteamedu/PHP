<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Observer;

use App\Model\Product\Entity\Product\Events;
use App\Model\Product\Entity\Product\ProductInterface;
use App\Model\Product\Entity\Recipe\RecipeFactory;
use DomainException;

class ProductPostCookObserver implements ObserverInterface
{
    private RecipeFactory $recipeFactory;

    public function __construct(RecipeFactory $recipeFactory)
    {
        $this->recipeFactory = $recipeFactory;
    }

    public function getEventName(): string
    {
        return Events::EVENT__POST_COOK;
    }

    public function handle(ObservableInterface $observable, string $eventName = ''): void
    {
        /* @var ProductInterface $observable */

        if ($eventName === $this->getEventName()) {
            if (!$observable->isCustomRecipeUsed()) {
                $this->assertProductMatchesToStandardRecipe($observable);
            }
        }
    }

    private function assertProductMatchesToStandardRecipe(ProductInterface $product): void
    {
        $standardRecipe = $this->recipeFactory->create($product->getName());

        if (!$product->areIngredientsExist($standardRecipe->getIngredients())) {
            $product->disposeOf();

            throw new DomainException($product->getName() . ' не соотвествовал рецепту и был утилизирован');
        }
    }
}