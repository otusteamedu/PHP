<?php


namespace App\price\schemes;


use App\Product;

class FreeProducts extends SchemePrice
{
    /** @var Product[] */
    private $products = [];

    protected function execute()
    {
        foreach ($this->products as $good)
            $this->order->getBasket()->add($good);
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct($product)
    {
        $product->setPrice(0);
        $this->products[] = $product;
        return $this;
    }
}