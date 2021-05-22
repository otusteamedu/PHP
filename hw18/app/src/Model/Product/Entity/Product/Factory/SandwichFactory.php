<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Factory;

use App\Model\Product\Entity\Product\ProductInterface;
use App\Model\Product\Entity\Product\Sandwich;

class SandwichFactory implements ProductFactoryInterface
{
    public function createProduct(): ProductInterface
    {
        return new Sandwich();
    }
}