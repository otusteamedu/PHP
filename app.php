<?php

use \Builder\Build;
use \Builder\Order;

try {
    $build = new Build(
        new \Client\B2B(),
        [
            new \Product\ProductA(),
            new \Product\ProductB()
        ],
        [
            new \Service\ServiceA(),
            new \Service\ServiceB()
        ]
    );

    $order = new Order($build->getResult(), new \Delivery\Plane());


} catch (Exception $e) {
    echo $e->getMessage();
} 
