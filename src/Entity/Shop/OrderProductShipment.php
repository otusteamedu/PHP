<?php declare(strict_types=1);

namespace Entity\Shop;

class OrderProductShipment
{
    private OrderProduct $orderProduct;

    private Shipment $shipment;

    public function getOrderProduct(): OrderProduct
    {
        return $this->orderProduct;
    }

    public function setOrderProduct(OrderProduct $orderProduct): void
    {
        $this->orderProduct = $orderProduct;
    }

    public function getShipment(): Shipment
    {
        return $this->shipment;
    }

    public function setShipment(Shipment $shipment): void
    {
        $this->shipment = $shipment;
    }
}
