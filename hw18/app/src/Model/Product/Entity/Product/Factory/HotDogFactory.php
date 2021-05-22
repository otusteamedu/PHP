<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Factory;

use App\Model\Product\Entity\Product\HotDog;
use App\Model\Product\Entity\Product\ProductInterface;

class HotDogFactory implements ProductFactoryInterface
{
    public function createProduct(): ProductInterface
    {
        return new HotDog();
    }
}