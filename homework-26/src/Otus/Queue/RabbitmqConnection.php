<?php

namespace Otus\Queue;

use Otus\Config\ConfigContract;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitmqConnection implements ConnectionContract
{
    public function connect(ConfigContract $config): QueueContract
    {
        $connection = new AMQPStreamConnection($config->get('queues.rabbitmq.host'), $config->get('queues.rabbitmq.port'), $config->get('queues.rabbitmq.user'), $config->get('queues.rabbitmq.password'), $config->get('queues.rabbitmq.vhost'));
        $channel = $connection->channel();
        $channel->queue_declare($config->get('queues.rabbitmq.queue'), $config->get('queues.rabbitmq.passive'), $config->get('queues.rabbitmq.durable'), $config->get('queues.rabbitmq.exclusive'), $config->get('queues.rabbitmq.auto_delete'));

        return new RabbitmqQueue($connection);
    }
}