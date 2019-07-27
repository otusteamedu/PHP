<?php

namespace App\Service;

use App\Config;
use ErrorException;
use Exception;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class RabbitService
 * @package App
 */
class RabbitService
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $chanel;

    /**
     * @var string
     */
    private $queue;

    /**
     * RabbitService constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->connection = new AMQPStreamConnection(
            $config::RABBIT_HOST,
            $config::RABBIT_PORT,
            $config::RABBIT_USER,
            $config::RABBIT_PASS
        );
        $this->queue = $config::RABBIT_QUEUE;
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, true, false, false);
    }

    /**
     * @param string $message
     */
    public function publish(string $message): void
    {
        $msg = new AMQPMessage($message, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        $this->channel->basic_publish($msg, '', $this->queue);
    }

    /**
     * @param $callback
     * @throws ErrorException
     */
    public function consume($callback): void
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume($this->queue, '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    /**
     * @throws Exception
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}