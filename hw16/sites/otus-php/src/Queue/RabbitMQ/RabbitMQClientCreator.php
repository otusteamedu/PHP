<?php

declare(strict_types=1);

namespace App\Queue\RabbitMQ;

use App\Exceptions\KernelException;
use App\Queue\QueueClientInterface;
use App\Queue\QueueClientCreatorInterface;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQClientCreator implements QueueClientCreatorInterface
{
    /**
     * @param array $config
     * @return QueueClientInterface
     * @throws KernelException
     * @throws \Exception
     */
    public static function create(array $config): QueueClientInterface
    {
        if (empty($config['rabbitmq_user'])
            || empty($config['rabbitmq_password'])
            || empty($config['rabbitmq_host'])
            || empty($config['rabbitmq_port'])
        ) {
            throw new \Exception('Установите параметры доступа к брокеру очередей');
        }

        $connection = new AMQPStreamConnection(
            $config['rabbitmq_host'],
            $config['rabbitmq_port'],
            $config['rabbitmq_user'],
            $config['rabbitmq_password']
        );

        return new Client($connection);
    }
}