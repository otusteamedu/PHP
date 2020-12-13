<?php 

namespace Drivers;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqDriver {
    private $connection;
    private $channel;
    private $queue;

    public function __construct(string $host, int $port, string $user, string $password, string $queue)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->connection->channel();
        $this->queue = $queue;
    }

    public function insert(string $message) : void
    {
        $this->channel->queue_declare($this->queue, false, false, false, false);
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', $this->queue);
    }

    public function disconnect() : void
    {
        $this->channel->close();
        $this->connection->close();
    }
}
