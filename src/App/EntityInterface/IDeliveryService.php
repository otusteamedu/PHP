<?php

namespace App\EntityInterface;

interface IDeliveryService
{
    /**
     * @return float
     */
    public function getPrice(): float;
}