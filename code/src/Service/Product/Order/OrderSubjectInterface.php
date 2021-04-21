<?php


namespace App\Service\Product\Order;


use App\Observer\OrderObserverInterface;

interface OrderSubjectInterface
{
    public function attach(OrderObserverInterface $observer): void;
    public function detach(OrderObserverInterface $observer): void;
    public function getObserver(): OrderObserverInterface;
    public function notify(): void;
}
