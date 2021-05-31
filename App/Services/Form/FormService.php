<?php


namespace App\Services\Form;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class FormService
{
    public const QUEUE_NAME = 'form_queue';

    private AMQPStreamConnection $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
    }

    public function publish(string $data)
    {
        if (!$this->connection->isConnected()) {
            $this->connection->reconnect();
        }
        $channel = $this->connection->channel();
        $channel->queue_declare(self::QUEUE_NAME, false, true, false, false);
        $channel->basic_publish(new AMQPMessage($data), '', self::QUEUE_NAME);
        $channel->close();
        $this->connection->close();
    }
}