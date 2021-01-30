<?php
return [
        'class' => \yii\queue\amqp\Queue::class,
        'host' => getenv('RABBITMQ_HOST'),
        'port' => getenv('RABBITMQ_PORT'),
        'user' => getenv('RABBITMQ_USER'),
        'password' => getenv('RABBITMQ_PASS'),
        'queueName' => getenv('RABBITMQ_QUEUE'),
        //'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_LIB,
];