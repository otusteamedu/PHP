<?php

namespace App\EntityInterface;

use App\Entity\DeliveryService;
use App\Entity\OrderContents;

interface IOrder
{
    /**
     * @param IProduct $product
     * @return static
     */
    public function addProduct(IProduct $product): IOrder;

    /**
     * @param IDiscount $discount
     * @return static
     */
    public function addDiscount(IDiscount $discount): IOrder;

    /**
     * @param DeliveryService $service
     * @return static
     */
    public function addDeliveryService(DeliveryService $service): IOrder;

    /**
     * @return float
     */
    public function getTotalPrice(): float;

    /**
     * @return OrderContents
     */
    public function getContents(): OrderContents;

    /**
     * @return IOrder
     */
    public function send(): IOrder;

    /**
     * @return static
     */
    public function revert(): IOrder;

    /**
     * @return bool
     */
    public function isB2C(): bool;

    /**
     * @return bool
     */
    public function isB2B(): bool;
}