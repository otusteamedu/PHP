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

    public function startLoop($callback) : void 
    {
        $this->channel->basic_consume($this->queue, '', false, true, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
