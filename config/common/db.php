<?php

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriverChain;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Roave\PsrContainerDoctrine\EntityManagerFactory;

return [
    'dependencies' => [
        'factories' => [
            EntityManagerInterface::class => EntityManagerFactory::class
        ],
    ],

    'config' => [
        'doctrine' => [
            'connection' => [
                'orm_default' => [
                    'params' => [
                        'url' => 'sqlite::var/db/db.sqlite'
                    ],
                ],
            ],
            'driver' => [
                'orm_default' => [
                    'class' => MappingDriverChain::class,
                    'drivers' => [
                        'App\Entity' => 'entity'
                    ],
                ],
                'entity' => [
                    'class' => AnnotationDriver::class,
                    'cache' => 'array',
                    'paths' => 'src/App/Entity',
                ],
            ],
        ],
        'fixture' => [
            'dir' => 'fixtures'
        ]
    ],
];
