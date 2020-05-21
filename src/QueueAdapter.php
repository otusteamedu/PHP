<?php
namespace Otus;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

final class QueueAdapter
{
    private $connection;
    private $channel;
    private const QUEUE_NAME = 'otus_hw16';

    public function __construct(string $host, string $user, string $pass, int $port = 5672)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $pass);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME, false, true, false, false);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function pushMsg(string $message): void
    {
        $msg = new AMQPMessage(
            $message,
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->channel->basic_publish($msg, '', self::QUEUE_NAME);
    }

    public function consuming(): void
    {
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            sleep(7);
            echo " [x] Done\n";
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };
        $this->channel->basic_consume(self::QUEUE_NAME, '', false, false, false, false, $callback);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }
}
