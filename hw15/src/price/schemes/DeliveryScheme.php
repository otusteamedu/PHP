<?php


namespace App\price\schemes;


class DeliveryScheme extends SchemePrice
{

    protected function execute()
    {
        $this->addTotal($this->getDeliveryPrice());
    }

    private function getDeliveryPrice()
    {
        $delivery = $this->order->getDelivery();
        if ($delivery)
            return $delivery->getPrice();
        return 0;
    }
}