<?php

namespace App\EntityFilter;

class ProductFilter extends CommonEntityFilter
{
    public const MAX_WEIGHT = 'max_weight';
    public const MIN_WEIGHT = 'min_weight';
    public const MIN_PRICE = 'min_price';
    public const MAX_PRICE = 'max_price';
    public const ORDER = 'order_id';

    private float $maxWeight = 0;
    private float $minWeight = 0;
    private float $minPrice = 0;
    private float $maxPrice = 0;
    private int $orderId = 0;

    /**
     * @param array|null $assoc
     * @return array
     */
    public function fetchToAssoc(?array $assoc = null): array
    {
        return parent::fetchToAssoc(
            [
                self::MAX_WEIGHT => $this->maxWeight,
                self::MIN_WEIGHT => $this->minWeight,
                self::MIN_PRICE  => $this->minPrice,
                self::MAX_PRICE  => $this->maxPrice,
                self::ORDER      => $this->orderId,
            ]
        );
    }

    /**
     * @param array $row
     * @return IEntityFilter
     */
    public static function buildFromAssoc(array $row): IEntityFilter
    {
        return (new self($row[self::ID] ?? 0))->setMinWeight(
            $row[self::MIN_WEIGHT] ?? 0
        )->setMaxWeight($row[self::MAX_WEIGHT] ?? 0)->setMinPrice(
            $row[self::MIN_PRICE] ?? 0
        )->setMaxPrice($row[self::MAX_PRICE] ?? 0)->setOrderId(
            $row[self::ORDER] ?? 0
        );
    }

    /**
     * @return float
     */
    public function getMaxWeight(): float
    {
        return $this->maxWeight;
    }

    /**
     * @param float $maxWeight
     * @return ProductFilter
     */
    public function setMaxWeight(float $maxWeight): ProductFilter
    {
        $this->maxWeight = $maxWeight;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinWeight(): float
    {
        return $this->minWeight;
    }

    /**
     * @param float $minWeight
     * @return ProductFilter
     */
    public function setMinWeight(float $minWeight): ProductFilter
    {
        $this->minWeight = $minWeight;
        return $this;
    }

    /**
     * @return float
     */
    public function getMinPrice(): float
    {
        return $this->minPrice;
    }

    /**
     * @param float $minPrice
     * @return ProductFilter
     */
    public function setMinPrice(float $minPrice): ProductFilter
    {
        $this->minPrice = $minPrice;
        return $this;
    }

    /**
     * @return float
     */
    public function getMaxPrice(): float
    {
        return $this->maxPrice;
    }

    /**
     * @param float $maxPrice
     * @return ProductFilter
     */
    public function setMaxPrice(float $maxPrice): ProductFilter
    {
        $this->maxPrice = $maxPrice;
        return $this;
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
     * @return ProductFilter
     */
    public function setOrderId(int $orderId): ProductFilter
    {
        $this->orderId = $orderId;
        return $this;
    }
}