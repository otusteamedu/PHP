<?php


namespace App\Service\Messenger;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;


class RabbitChannelBuilder implements ChannelBuilderInterface
{

    private AMQPStreamConnection $connection;
    private string $queueName;


    /**
     * RabbitChannelBuilder constructor.
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     * @param string $queueName
     */
    public function __construct(AMQPStreamConnection $connection, string $queueName = 'app-queue')
    {
        $this->connection = $connection;
        $this->queueName = $queueName;
    }


    public function build(): AMQPChannel
    {
        $channel = $this->connection->channel();
        $channel->queue_declare($this->queueName, false, true, false, false);
        $channel->basic_qos(null, 1, null);

        return $channel;
    }


    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }

    public function setQueueName(string $queueName): ChannelBuilderInterface
    {
        $this->queueName = $queueName;
        return $this;
    }

    public function getQueueName(): string
    {
        return $this->queueName;
    }
}
