<?php


namespace nvggit\hw26;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Channel\AMQPChannel;

/**
 * Class RabbitMq
 * @package nvggit
 *
 * @property AMQPStreamConnection $connection
 * @property AMQPChannel $channel
 * @property string $queue
 * @property string $response
 * @property string $corrId
 */
abstract class RabbitMq
{
    protected $connection;
    protected $channel;
    protected $queue;
    protected $response;
    protected $corrId;


    public function __construct(string $queue)
    {
        $this->queue = $queue;
        $this->corrId = uniqid();
    }

    protected function connect()
    {
        $this->connection = new AMQPStreamConnection(
            'localhost',
            5672,
            'guest',
            'guest'
        );
    }

    protected function setChannel()
    {
        $this->channel = $this->connection->channel();
    }

    protected function declareChannel()
    {
        $this->channel->queue_declare(
            $this->queue,
            false,
            false,
            false,
            false
        );
    }

    protected function consumeChannel()
    {
        $this->channel->basic_consume(
            $this->queue,
            '',
            false,
            false,
            false,
            false,
            array($this, 'onResponse')
        );
    }

    protected function basicQos()
    {
        $this->channel->basic_qos(null, 1, null);
    }

    /**
     * @param string $message
     * @return AMQPMessage
     */
    protected function createMsg(string $message): AMQPMessage
    {
        return new AMQPMessage(
            $message,
            array(
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
                'correlation_id' => $this->corrId,
                'reply_to' => $this->queue
            )
        );
    }

    /**
     * @param AMQPMessage $message
     */
    protected function publishMsg(AMQPMessage $message)
    {
        $this->channel->basic_publish(
            $message,
            '',
            $this->queue
        );
    }

    public abstract function onResponse(AMQPMessage $msg);

}