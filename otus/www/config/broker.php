<?php
$dotenv = Dotenv\Dotenv::createImmutable(\App\AppSettings::DOCUMENT_ROOT . 'config/' );
$config = $dotenv->load();

return [
    'broker' => $config['BROKER'],
    'brokers' => [
        'rabbit' => [
            'host' => $config['RABBIT_MQ_HOST'],
            'port' => $config['RABBIE_MQ_PORT'],
            'user' => $config['RABBIE_MQ_USER'],
            'password' => $config['RABBIE_MQ_PASSWORD'],
            'queue_request' => $config['RABBIT_QUEUE_REQUEST_NAME'],
            'queue_response' => $config['RABBIT_QUEUE_RESPONSE_NAME'],
        ]
    ]
];
