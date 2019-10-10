<?php

namespace TimGa\hw26\rabbitmq;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqFairDispatch
{

    private $connection;
    private $channel;

    public function __construct()
    {
        $connection = new AMQPStreamConnection('192.168.56.101', 5672, 'timofey', 'timofey123');
        $channel = $connection->channel();
        $this->connection = $connection;
        $this->channel = $channel;
    }

    public function publishData($data, $queueName)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $msg = new AMQPMessage($data, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $this->channel->basic_publish($msg, '', $queueName);
    }

    public function consumeData($queueName, $callback)
    {
        $this->channel->queue_declare($queueName, false, true, false, false);
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($queueName, '', false, false, false, false, $callback);
        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }

}
