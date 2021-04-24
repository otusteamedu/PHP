<?php


namespace App\Shop;


use SplSubject;

class OrderStatusNotify implements \SplObserver
{

    public function update(SplSubject $subject, string $event = null, $data = null)
    {
        if ($event === Order::EVENTS['STATUS_UPDATE']) {
            echo "Your order {$data['id']} is ${data['status']}\n";
        }
    }
}