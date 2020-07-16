<?php


namespace App\Components\Rabbit;


use App\Queue\QueueResponse;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbit
{
    const QUEUE_REQUEST = 'request';
    const QUEUE_RESPONSE = 'response';

    public AMQPStreamConnection $conn;
    public AMQPChannel $channel;

    public function __construct($host, $port, $user, $password)
    {
        $this->conn = new AMQPStreamConnection($host, $port, $user, $password);
        $this->channel = $this->conn->channel();
        $this->channel->queue_declare(self::QUEUE_REQUEST, false, false, false, false);
        $this->channel->queue_declare(self::QUEUE_RESPONSE, false, false, false, false);
    }

    public static function create()
    {
        return new self(getenv('HOST'), getenv('PORT'), getenv('USERNAME'), getenv('PASSWORD'));
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->conn->close();
    }

    public function pushRequest($request)
    {
        $this->pushQueue(self::QUEUE_REQUEST, $request);
    }

    public function pushResponse($response)
    {
        $this->pushQueue(self::QUEUE_RESPONSE, $response);
    }

    public function popRequest()
    {
        if (!($message = $this->readQueue(self::QUEUE_REQUEST))) {
            return null;
        }
        $requestItem = $message;
        $this->deleteMessage($message);
        return json_decode($requestItem->body, true);
    }

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
        if (!$message) {
            return null;
        }

        $item = QueueResponse::createByJson($message->body);
        if (!$item->check($requestID)) {
            return null;
        }
        return $item;
    }

    private function deleteMessage($message)
    {
        $this->channel->basic_ack($message->getDeliveryTag());
    }
}