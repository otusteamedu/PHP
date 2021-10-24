<?php

namespace App\Services\Orders;

use App\Exceptions\ErrorCodes;
use App\Exceptions\Orders\InvalidProductOrderException;

class ProxyProductOrder implements IProductOrder
{
    private ProductOrder $productOrder;

    /**
     * @param ProductOrder $productOrder
     */
    public function __construct(ProductOrder $productOrder)
    {
        $this->productOrder = $productOrder;
    }

    /**
     * @return IProductOrder
     */
    public function getOrder(): IProductOrder
    {
        return $this;
    }

    /**
     * @return string
     * @throws InvalidProductOrderException
     */
    public function getProduct(): string
    {
        if ($this->checkQuality()) {
            return $this->productOrder->getProduct();
        } else {
            // TODO: произвести изменения в базе
            throw new InvalidProductOrderException($this->productOrder->getProduct() . "<b style='color:red'> УТИЛИЗИРОВАН!</b>", ErrorCodes::getCode(InvalidProductOrderException::class));
        }
    }

    public function createProduct(string $baseType = '', array $ingredientsList = [], array $saucesList = []): IProductOrder
    {
        $this->productOrder->createProduct($baseType, $ingredientsList, $saucesList);
        return $this;
    }

    public function prepareProduct(): ProxyProductOrder
    {
        $this->productOrder->prepareProduct();
        return $this;
    }

    private function checkQuality(): bool
    {
        return (float)$_ENV['PROBABILITY_PRODUCT_DEFECT'] === 0.0 || (bool)rand(0, (100 / (float)$_ENV['PROBABILITY_PRODUCT_DEFECT']) - 1);
    }
}