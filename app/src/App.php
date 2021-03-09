<?php
namespace Otus;

use Otus\Controller\OrderController;

class App
{
    public function run()
    {
        $order = new OrderController();
        $order->makeOrder();
    }
}