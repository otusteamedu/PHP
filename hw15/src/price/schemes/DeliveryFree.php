<?php


namespace App\price\schemes;


class DeliveryFree extends SchemePrice
{

    protected function execute()
    {
        $delivery = $this->order->getDelivery();
        if ($delivery)
            $delivery->setPrice(0);
    }
}