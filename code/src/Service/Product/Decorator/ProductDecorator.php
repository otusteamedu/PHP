<?php


namespace App\Service\Product\Decorator;


use App\Entity\Ingredient;
use App\Entity\ProductInterface;

class ProductDecorator implements ProductDecoratorInterface
{
    protected ProductInterface $product;

    public function setProduct(ProductInterface $product)
    {
        $this->product = $product;
    }

    public function addIngredients(array $ingredients): ProductInterface
    {
        foreach ($ingredients as $name => $isDouble) {
            $ingredient = new Ingredient($name, $isDouble);
            $this->product->addIngredient($ingredient);
        }

        return $this->product;
    }

}
