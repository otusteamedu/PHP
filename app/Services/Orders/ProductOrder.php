<?php

namespace App\Services\Orders;

use App\Services\Factories\ProductFactory\AbstractProductBase;
use App\Services\Factories\ProductFactory\AbstractProductFactory;
use App\Services\Factories\ProductFactory\IIngredient;
use App\Services\Factories\ProductFactory\ISauce;


class ProductOrder
{
    private AbstractProductFactory $factory;
    private ISauce $sauces;
    private IIngredient $ingredients;
    private AbstractProductBase $base;


    /**
     * @param AbstractProductFactory $factory
     */
    public function __construct(AbstractProductFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return $this
     */
    public function getOrder(): ProductOrder
    {
        //todo сформировать заказ
        return $this;
    }

    /**
     * @return $this
     */
    public function createProduct(string $baseType = '', array $ingredientsList = [], array $saucesList =[]): ProductOrder
    {
        return $this->createBase($baseType)
            ->createIngredients($ingredientsList)
            ->createSauces($saucesList);
    }

    /**
     * @param string $type
     * @return $this
     */
    public function createBase(string $type): ProductOrder
    {
        $this->base = $this->factory->createBase($type);
        return $this;
    }

    /**
     * @param array $ingredientsList
     * @return $this
     */
    private function createIngredients(array $ingredientsList): ProductOrder
    {
        $this->ingredients = $this->factory->createIngredients($ingredientsList);
        return $this;
    }

    /**
     * @param array $sauces
     * @return $this
     */
    private function createSauces(array $sauces): ProductOrder
    {
        $this->sauces = $this->factory->createSauces($sauces);
        return $this;
    }

    /**
     * @return $this
     */
    public function prepareProduct(): self
    {
        $this->base
            ->prepare()
            ->setStatusReady();
        $this->ingredients
            ->prepare()
            ->addToProduct()
            ->toArray();
        $this->sauces
            ->addToProduct()
            ->toArray();
        return $this;
    }

    /**
     * @return string
     */
    public function getProduct(): string
    {
        $result = $this->base->getProductBase();
        $result .= "Ингредиенты: " . $this->ingredients->getIngredients();
        $result .= "Соусы: " . $this->sauces->getSauces();
        return $result;
    }
}