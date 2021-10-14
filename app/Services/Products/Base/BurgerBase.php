<?php

namespace App\Services\Products\Base;

use App\Services\Factories\ProductFactory\AbstractProductBase;

class BurgerBase extends AbstractProductBase
{

    const PRODUCT_BASE_NAME = 'Основа для бургера';


    /**
     * @param string $size
     * @param string $type
     */
    public function __construct(string $size, string $type)
    {
        $this->size = $size;
        $this->type = $type;
        parent::__construct();
    }
}