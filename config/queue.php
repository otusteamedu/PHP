<?php
return [
    'default'     => env('QUEUE_CONNECTION', 'sync'),
    'connections' => [
        'rabbitmq' => [
            'driver'     => 'rabbitmq',
            'queue'      => env('RABBITMQ_QUEUE', 'default'),
            'connection' => PhpAmqpLib\Connection\AMQPLazyConnection::class,
            'hosts'      => [
                [
                    'host'     => env('RABBIT_HOST'),
                    'port'     => env('RABBIT_PORT', 5672),
                    'user'     => env('RABBIT_USER', 'guest'),
                    'password' => env('RABBIT_PASSWORD', 'guest'),
                    'vhost'    => env('RABBITMQ_VHOST', '/'),
                ],
            ],
            'options'    => [
                'ssl_options' => [
                    'cafile'      => env('RABBITMQ_SSL_CAFILE', null),
                    'local_cert'  => env('RABBITMQ_SSL_LOCALCERT', null),
                    'local_key'   => env('RABBITMQ_SSL_LOCALKEY', null),
                    'verify_peer' => env('RABBITMQ_SSL_VERIFY_PEER', true),
                    'passphrase'  => env('RABBITMQ_SSL_PASSPHRASE', null),
                ],
                'queue'       => [
                    'job' => VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob::class,
                ],
            ],

            /*
              * Set to "horizon" if you wish to use Laravel Horizon.
              */
            'worker'     => env('RABBITMQ_WORKER', 'default'),
        ],
    ]
];