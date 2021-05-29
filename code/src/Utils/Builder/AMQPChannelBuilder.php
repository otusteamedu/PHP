<?php


namespace App\Utils\Builder;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;


class AMQPChannelBuilder implements AMQPChannelBuilderInterface
{

    private AMQPStreamConnection $connection;
    private string $queueName;


    /**
     * AMQPChannelBuilder constructor.
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

    public function setQueueName(string $queueName): AMQPChannelBuilderInterface
    {
        $this->queueName = $queueName;
        return $this;
    }

    public function getQueueName(): string
    {
        return $this->queueName;
    }
}
