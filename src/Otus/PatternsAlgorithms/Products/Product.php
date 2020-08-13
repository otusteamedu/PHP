<?php


namespace App\Otus\PatternsAlgorithms\Products;


use App\Otus\PatternsAlgorithms\Package;

abstract class Product
{
    /**
     * Name of the product (to be overwritten by child classes).
     *
     * @var string
     */
    protected $name = '';

    /**
     * Price of the product.
     *
     * @var float
     */
    private $price;

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

}