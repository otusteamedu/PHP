<?php


namespace App\Otus\PatternsAlgorithms;


use App\Otus\PatternsAlgorithms\Products\Product;

class Package
{
    /**
     * Products contained in the shipment.
     *
     * @var Product[]
     */
    private $products;


    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param Product $product
     */
    public function addProduct(Product $product): void
    {
        $this->products[] = $product;
    }


}