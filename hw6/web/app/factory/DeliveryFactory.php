<?php

namespace factory;

use factory\DeliveryBoxberry;

class DeliveryFactory
{
    const AVAILABLE_NAMES = [
        'boxberry',
    ];


    public function __construct($name)
    {
        switch ($name) {
            case 'boxberry':
                return new DeliveryBoxberry();
            default:
                throw new \Exception('Unknown delivery');
        }
    }
}