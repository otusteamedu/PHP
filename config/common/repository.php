<?php

use App\Repository\OrderRepository;
use Infrastructure\Container\Repository\OrderRepositoryFactory;

return [
    'dependencies' => [
        'factories' => [
            OrderRepository::class => OrderRepositoryFactory::class
        ]
    ]
];
