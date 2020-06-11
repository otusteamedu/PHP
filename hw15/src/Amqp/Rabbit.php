<?php


namespace App\Amqp;


use App\Queue\Items\RequestItem;
use App\Queue\QueueBroker;
use App\Queue\Items\ResponseItem;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbit implements QueueBroker
{
    const QUEUE_REQUEST = 'requests';
    const QUEUE_RESPONSE = 'response';

    private $conn;
    private $channel;

    public function __construct($config)
    {
        $this->conn = new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password']);
        $this->channel = $this->conn->channel();

        $this->channel->queue_declare(self::QUEUE_REQUEST, false, false, false, false);
        $this->channel->queue_declare(self::QUEUE_RESPONSE, false, false, false, false);
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->conn->close();
    }

    public function pushRequest(RequestItem $requestItem)
    {
        $this->pushQueue(self::QUEUE_REQUEST, $requestItem->toJson());
    }

    public function pushResponse(ResponseItem $responseItem)
    {
        $this->pushQueue(self::QUEUE_RESPONSE, $responseItem->toJson());
    }


    public function popRequest()
    {
        if (!($message = $this->readQueue(self::QUEUE_REQUEST)))
            return null;

        $requestItem = RequestItem::createByJson($message->body);
        if (!$requestItem)
            return null;

        $message->ack();
        //$this->deleteMessage($message);
        return $requestItem;
    }

    /**
     * @param string $queueName
     * @return AMQPMessage|null mixed
     */
    private function readQueue($queueName)
    {
        return $this->channel->basic_get($queueName);
    }

    private function pushQueue($queueName, $content)
    {
        $msg = new AMQPMessage($content);
        $this->channel->basic_publish($msg, '', $queueName);
    }


    public function popResponse($requestID)
    {
        $message = $this->readQueue(self::QUEUE_RESPONSE);
        if (!$message)
            return null;

        $item = ResponseItem::createByJson($message->body);
        if (!$item->check($requestID))
            return null;

        $message->ack();
        //$this->deleteMessage($message);
        return $item;
    }

    /**
     * @param AMQPMessage $message
     */
    private function deleteMessage($message)
    {
        //$message->ack();
        $this->channel->basic_ack($message->getDeliveryTag());
    }


}