<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product;

class Events
{
    public const EVENT__COOKED    = 'cooked';
    public const EVENT__PRE_COOK  = 'pre_cook';
    public const EVENT__POST_COOK = 'post_cook';
}