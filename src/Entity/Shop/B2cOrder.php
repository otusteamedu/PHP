<?php declare(strict_types=1);

namespace Entity\Shop;

class B2cOrder extends AbstractOrder
{
    public function getType(): string
    {
        return self::ORDER_TYPE_B2C;
    }
}
