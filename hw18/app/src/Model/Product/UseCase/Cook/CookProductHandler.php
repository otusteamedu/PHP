<?php

declare(strict_types=1);

namespace App\Model\Product\UseCase\Cook;

use App\Model\Product\Entity\Product\Decorator\IngredientDecoratorFactory;
use App\Model\Product\Entity\Product\Decorator\RecipeDecorator;
use App\Model\Product\Entity\Product\Proxy\ProxyProduct;
use App\Model\Product\Entity\Product\Strategy\ProductStrategyFactory;
use App\Model\Product\Service\ProductObserversRegistrar;

class CookProductHandler
{
    private ProductStrategyFactory     $productStrategyFactory;
    private IngredientDecoratorFactory $ingredientDecoratorFactory;
    private ProductObserversRegistrar  $observersRegistrar;

    public function __construct(
        ProductStrategyFactory $productStrategyFactory,
        IngredientDecoratorFactory $ingredientDecoratorFactory,
        ProductObserversRegistrar $observersRegistrar
    ) {
        $this->productStrategyFactory = $productStrategyFactory;
        $this->ingredientDecoratorFactory = $ingredientDecoratorFactory;
        $this->observersRegistrar = $observersRegistrar;
    }

    public function handle(CookProductCommand $command): void
    {
        $productStrategy = $this->productStrategyFactory->create($command->productName);

        $productFactory = $productStrategy->getProductFactory();

        $product = $productFactory->createProduct();

        $product = new ProxyProduct($product);

        if ($command->isCustomRecipeUsed) {
            $product->markIsCustomRecipeUsed();

            foreach ($command->ingredients as $ingredientName) {
                $product = $this->ingredientDecoratorFactory->create($product, $ingredientName);
            }
        } else {
            $product = new RecipeDecorator($product);
        }

        $this->observersRegistrar->register($product);

        $product->cook();
    }
}