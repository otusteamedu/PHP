<?php

declare(strict_types=1);

namespace App\Queue\RabbitMQ;

use App\Exceptions\KernelException;
use App\Queue\QueueClientInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class Client implements QueueClientInterface
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var AMQPChannel
     */
    private $channel;

    /**
     * @var callable
     */
    private $consumeCallback = null;

    /**
     * @param AMQPStreamConnection $connection
     * @throws KernelException
     */
    public function __construct($connection)
    {
        $this->connection = $connection;
        $this->channel = $this->connection->channel();
    }

    /**
     * @param string $data
     * @param string $exchangeName
     * @param string $routingKey
     * @param bool $mandatory
     * @param array $messageParams
     */
    public function publish(
        string $data,
        string $exchangeName = '',
        string $routingKey = '',
        bool $mandatory = false,
        array $messageParams = []
    ) {
        $msg = new AMQPMessage(
            $data,
            $messageParams
        );

        $this->channel->basic_publish($msg, $exchangeName, $routingKey, $mandatory);
    }

    public function consume(string $queueName, array $options = [])
    {
        $consumerTag = empty($options['consumer_tag']) ? '' : $options['consumer_tag'] ;
        $noLocal = empty($options['no_local']) ? false : $options['no_local'] ;
        $noAck = empty($options['no_ack']) ? false : $options['no_ack'] ;
        $exclusive = empty($options['exclusive']) ? false : $options['exclusive'] ;
        $noWait = empty($options['no_wait']) ? false : $options['no_wait'] ;

        $this->channel->basic_consume($queueName, $consumerTag, $noLocal, $noAck, $exclusive, $noWait, $this->consumeCallback);
    }

    public function exchangeDeclare(string $exchangeName, array $options = [])
    {
        $type = empty($options['type']) ? AMQPExchangeType::DIRECT : $options['type'];
        $passive = empty($options['passive']) ? false : $options['passive'];
        $durable = empty($options['durable']) ? true : $options['false'];
        $autoDelete = empty($options['auto_delete']) ? false : $options['auto_delete'];

        $this->channel->exchange_declare($exchangeName, $type, $passive, $durable, $autoDelete);
    }

    public function queueDeclare(string $name, array $options = [])
    {
        $passive = empty($options['passive']) ? false : $options['passive'];
        $durable = empty($options['durable']) ? true : $options['false'];
        $exclusive = empty($options['exclusive']) ? false : $options['exclusive'];
        $autoDelete = empty($options['auto_delete']) ? false : $options['auto_delete'];

        $this->channel->queue_declare($name, $passive, $durable, $exclusive, $autoDelete);
    }

    public function queueBind($queue, $exchange, $routingKey = '')
    {
        $this->channel->queue_bind($queue, $exchange, $routingKey);
    }

    public function channelConfirmSelect()
    {
        $this->channel->confirm_select();
    }

    public function isChannelConsuming()
    {
        return $this->channel->is_consuming();
    }

    /**
     * @throws \ErrorException
     */
    public function channelWaits()
    {
        return $this->channel->wait();
    }

    public function setAckHandler(callable $callable)
    {
        $this->channel->set_ack_handler($callable);
    }

    public function setNAckHandler(callable $callable)
    {
        $this->channel->set_nack_handler($callable);
    }

    public function setReturnListener(callable $callable)
    {
        $this->channel->set_return_listener($callable);
    }

    public function setConsumeHandler(callable $callable)
    {
        $this->consumeCallback = $callable;
    }

    public function waitForPendingReturns()
    {
        $this->channel->wait_for_pending_acks_returns();
    }

    public function getDeliveryTag($message)
    {
        return $message->delivery_info['delivery_tag'];
    }

    public function ackMessage($message)
    {
        $deliveryTag = $this->getDeliveryTag($message);

        $message->delivery_info['channel']->basic_ack($deliveryTag);
    }

    public function nackMessage($message)
    {
        $deliveryTag = $this->getDeliveryTag($message);

        $message->delivery_info['channel']->basic_nack($deliveryTag);
    }

    /**
     * @throws \Exception
     */
    public function close()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
