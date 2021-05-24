<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Factory;

use App\Model\Product\Entity\Product\ProductInterface;

interface ProductFactoryInterface
{
    public function createProduct(): ProductInterface;
}