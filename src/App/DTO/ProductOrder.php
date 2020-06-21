<?php

namespace Ozycast\App\DTO;

use Ozycast\App\Core\DTO;

Class ProductOrder extends DTO
{
    /**
     * @var int
     */
    private $product_id;

    /**
     * @var int
     */
    private $order_id;

    /**
     * @var int
     */
    private $count;

    /**
     * @var int
     */
    private $parcel_id = null;

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }

    /**
     * @param int $product_id
     */
    public function setProductId(int $product_id)
    {
        $this->product_id = $product_id;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->order_id;
    }

    /**
     * @param int $order_id
     */
    public function setOrderId(int $order_id)
    {
        $this->order_id = $order_id;
    }


    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function getParcelId(): ?int
    {
        return $this->parcel_id;
    }

    /**
     * @param int $parcel_id
     */
    public function setParcelId(int $parcel_id)
    {
        $this->parcel_id = $parcel_id;
    }

}