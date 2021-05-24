<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Factory;

use App\Model\Product\Entity\Product\Burger;
use App\Model\Product\Entity\Product\ProductInterface;

class BurgerFactory implements ProductFactoryInterface
{
    public function createProduct(): ProductInterface
    {
        return new Burger();
    }
}