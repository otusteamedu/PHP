<?php

use App\Controller\BillingController;
use Infrastructure\Container\Controller\BillingControllerFactory;

return [
    'dependencies' => [
        'factories' => [
            BillingController::class => BillingControllerFactory::class
        ],
    ]
];
