<?php

namespace App\EntityInterface;

interface IOrderCalculator
{
    /**
     * @return float
     */
    public function getTotalPrice(): float;
}