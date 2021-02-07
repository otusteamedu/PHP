<?php


namespace Otushw\Models;

use Otushw\Article;

abstract class Reviews extends Article
{
    protected string $nameProduct;

    /**
     * @return string
     */
    abstract public function getNameProduct(): string;

    /**
     * @param string $nameProduct
     */
    abstract public function setNameProduct(string $nameProduct): void;
}