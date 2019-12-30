<?php


namespace App;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Class SendQueueRpcClient
 * @package App
 */
class SendQueueRpcClient
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;
    /**
     * @var \PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;
    /**
     * @var
     */
    private $callback_queue;
    /**
     * @var
     */
    private $response;
    /**
     * @var
     */
    private $corr_id;

    /**
     * SendQueueRpcClient constructor.
     * @param AMQPStreamConnection $RabbitMQ
     */
    public function __construct(AMQPStreamConnection $RabbitMQ)
    {
        $this->connection =$RabbitMQ;
        $this->channel = $this->connection->channel();
        list($this->callback_queue, ,) = $this->channel->queue_declare(
            "",
            false,
            false,
            true,
            false
        );
        $this->channel->basic_consume(
            $this->callback_queue,
            '',
            false,
            true,
            false,
            false,
            array(
                $this,
                'onResponse'
            )
        );
    }

    /**
     * @param $rep
     */
    public function onResponse($rep)
    {
        if ($rep->get('correlation_id') == $this->corr_id) {
            $this->response = $rep->body;
        }
    }

    /**
     * @param $n
     * @return null
     * @throws \ErrorException
     */
    public function call($n)
    {
        $this->response = null;
        $this->corr_id = uniqid();

        $msg = new AMQPMessage(
            (string)$n,
            array(
                'correlation_id' => $this->corr_id,
                'reply_to' => $this->callback_queue
            )
        );
        $this->channel->basic_publish($msg, '', 'rpc_queue');
        while (!$this->response) {
            $this->channel->wait();
        }
        return $this->response;
    }
}


