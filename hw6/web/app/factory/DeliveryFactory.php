<?php

namespace factory;

use factory\DeliveryBoxberry;

class DeliveryFactory
{
    const AVAILABLE_NAMES = [
        'boxberry',
    ];


    public function __construct(Order $order, $name)
    {
        switch ($name) {
            case 'boxberry':
                return new DeliveryBoxberry($order);
            default:
                throw new \Exception('Unknown delivery');
        }
    }
}