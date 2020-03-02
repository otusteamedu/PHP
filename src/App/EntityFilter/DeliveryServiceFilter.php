<?php

namespace App\EntityFilter;

class DeliveryServiceFilter extends CommonEntityFilter
{
    public const ORDER = 'order_id';

    private int $orderId = 0;

    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchToAssoc(?array $assoc = null): array
    {
        return parent::fetchToAssoc(
            [
                self::ORDER => $this->orderId,
            ]
        );
    }

    /**
     * @param array $row
     * @return DeliveryServiceFilter
     */
    public static function buildFromAssoc(array $row): IEntityFilter
    {
        return (new self($row[self::ID] ?? 0))->setOrderId(
            $row[self::ORDER] ?? 0
        );
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     * @return DeliveryServiceFilter
     */
    public function setOrderId(int $orderId): DeliveryServiceFilter
    {
        $this->orderId = $orderId;
        return $this;
    }
}