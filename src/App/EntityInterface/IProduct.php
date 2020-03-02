<?php

namespace App\EntityInterface;

interface IProduct
{
    /**
     * @return float
     */
    public function getPrice(): float;
}