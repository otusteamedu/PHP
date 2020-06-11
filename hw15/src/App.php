<?php


namespace App;



use Api\Api;
use App\Amqp\Rabbit;
use App\delivery\DeliveryA;
use App\price\CustomPricer;

class App
{
    const PATH_CFG_AMQP = 'config/amqp.php';

    public function run()
    {
        if ($this->isApiRequest())
            return $this->runApi();

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

    private function isApiRequest()
    {
        //some logic example: stripos($_SERVER['REQUEST_URI'] ?? '', 'api/') === 0
        return true;
    }

    private function runApi()
    {
        $api = new Api\Api();

        $config = require_once(self::PATH_CFG_AMQP);
        $rabbit = new Rabbit($config);
        return $api->run($rabbit);
    }

}