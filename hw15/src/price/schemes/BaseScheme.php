<?php


namespace App\price\schemes;



class BaseScheme extends SchemePrice
{

    public function execute()
    {
        $total = 0;
        $basket = $this->order->getBasket();
        foreach ($basket->getProducts() as $good)
            $total += $good->getPrice() * $basket->count($good->getId());

        $this->order->setTotal($total);
        return $this;
    }

}