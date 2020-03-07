<?php

declare(strict_types=1);

namespace App\Product;

class Product
{
    protected $id;

    protected $size;

    protected $regularPrice;

    public function getId()
    {
        return $this->id;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getRegularPrice()
    {
        return $this->regularPrice;
    }

    public function setRegularPrice($price)
    {
        $this->regularPrice = $price;
    }
}