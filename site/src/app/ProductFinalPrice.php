<?php


namespace App;


class ProductFinalPrice
{
    private $productId;
    private $productsPrice;

    /**
     * @return mixed
     */
    public function getProductsPrice()
    {
        return $this->productsPrice;
    }

    /**
     * @param mixed $productsPrice
     */
    public function setProductsPrice($productsPrice)
    {
        $this->productsPrice = $productsPrice;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param mixed $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    public function __construct($productId,$productsPrice)

    {
        $this->productId=$productId;
        $this->productsPrice=$productsPrice;
    }

}