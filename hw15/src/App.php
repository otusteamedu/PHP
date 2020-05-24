<?php


namespace App;



use App\delivery\Delivery;
use App\delivery\DeliveryA;
use App\price\CustomPricer;

class App
{
    public function run()
    {
        $basket = new Basket();
        foreach ($this->createGoods() as $good)
            $basket->add($good);

        $delivery = new DeliveryA();

        $order = new Order();
        $order->setBasket($basket)->setDelivery($delivery);

        $pricer = CustomPricer::create($order);

        OrderBuilder::create($order)
            ->setPricer($pricer)
            ->build();


        echo $order->getTotal();
        echo PHP_EOL;
    }

    private function createGoods()
    {
        return [
            (new Product(1, 100.0))->setPackageID(1),
            (new Product(2, 150.0))->setPackageID(2)
        ];
    }

}