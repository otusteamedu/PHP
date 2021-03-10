<?php


namespace Otushw\Queue;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;
use Otushw\Message;

class RabbitMQ implements QueueInterface
{
    const EXCHANGE = 'custom_exchange';
    const QUEUE_NAME = 'custom_queue_name';
    const ROUTING_KEY = 'custom_routing_key';

    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        $this->connect();
    }

    public function __destruct()
    {
        $this->disconnect();
    }

    public function publish(string $data): void
    {
        $this->queueDeclare();
        $this->channel->exchange_declare(
            self::EXCHANGE,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false
        );

        $this->channel->queue_bind(
            self::QUEUE_NAME,
            self::EXCHANGE,
            self::ROUTING_KEY
        );

        $msg = new AMQPMessage(
            $data,
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );
        $this->channel->basic_publish(
            $msg,
            self::EXCHANGE,
            self::ROUTING_KEY
        );
    }

    public function consume(): void
    {
        $this->queueDeclare();
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume(
            self::QUEUE_NAME,
            '',
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function processMessage($msg): void
    {
        $data = json_decode($msg->body);
        if (!empty($data)) {
            foreach ($data as $item) {
                Message::showMessage($item);
            }
            $this->channel->basic_ack($msg->delivery_info['delivery_tag']);
        }
    }

    private function queueDeclare(): void
    {
        $this->channel->queue_declare(
            self::QUEUE_NAME,
            false,
            true,
            false,
            false
        );
    }

    public function connect(): void
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['queue']['host'],
            $_ENV['queue']['port'],
            $_ENV['queue']['user'],
            $_ENV['queue']['password']
        );
        $this->channel = $this->connection->channel();
    }

    public function disconnect(): void
    {
        $this->channel->close();
        $this->connection->close();
    }
}