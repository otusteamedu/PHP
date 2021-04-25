<?php


namespace App\Console\Commands;


use App\Container;
use App\Shop\Observers\OrderObserver;
use App\Shop\Order;
use App\Shop\OrderController;
use App\Shop\OrderStatusNotify;

class OrderTestCommand implements \App\Console\CommandContract
{

    public function __construct(array $arguments = [])
    {
    }

    public function handle()
    {
        OrderObserver::getInstance()->attach(Container::make(OrderStatusNotify::class), Order::EVENTS['STATUS_UPDATE']);
        $controller = Container::make(OrderController::class);
        $id = $controller->post(['food' => 'burger', 'type' => 'beef', 'ingredients' => ['cheese', 'bacon']]);
        echo Order::get($id)->cook() . "\n\n";
        $id = $controller->post(['food' => 'ice-cream', 'ingredients' => ['chocolate', 'syrup']]);
        echo Order::get($id)->cook() . "\n";
    }
}