<?php

namespace App\Services\Orders;

interface IProductOrder
{
    public function getOrder(): IProductOrder;
    public function createProduct(string $baseType = '', array $ingredientsList = [], array $saucesList =[]): IProductOrder;
    public function prepareProduct(): IProductOrder;
    public function getProduct(): string;
}