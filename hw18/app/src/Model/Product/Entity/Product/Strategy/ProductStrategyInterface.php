<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Strategy;

use App\Model\Product\Entity\Product\Factory\ProductFactoryInterface;

interface ProductStrategyInterface
{
    public function getProductFactory(): ProductFactoryInterface;
}