<?php

namespace App\EntityInterface;

interface IDiscount
{
    /**
     * @param float|null $value
     * @return float
     */
    public function getValue(?float $value = null): float;
}