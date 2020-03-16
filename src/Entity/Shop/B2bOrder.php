<?php declare(strict_types=1);

namespace Entity\Shop;

final class B2bOrder extends AbstractOrder
{
    public function getType(): string
    {
        return self::ORDER_TYPE_B2B;
    }
}
