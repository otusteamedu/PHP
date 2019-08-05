<?php

namespace crazydope\theater\Job\Adapter;

use crazydope\theater\Model\Job;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMqAdapter implements AdapterInterface
{
    protected const QUEUE_NAME = 'theater_reviews';

    /**
     * @var AMQPStreamConnection
     */
    protected $connection;

    public function __construct(AMQPStreamConnection $connection)
    {
        $this->connection = $connection;
        $channel = $this->connection->channel();

        // Declare Queue
        $channel->queue_declare(self::QUEUE_NAME, false, true, false, false);
        $channel->close();
    }


    /**
     * @param string $message
     */
    public function publish(string $message): void
    {
        $channel = $this->connection->channel();

        // Create msg and publish
        $msg = new AMQPMessage($message, ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
        $channel->basic_publish($msg, '', self::QUEUE_NAME);

        $channel->close();
    }

    /**
     * @param callable $callback
     * @param int $maxJobs
     * @throws \ErrorException
     */
    public function consume(callable $callback, int $maxJobs = 1): void
    {
        $channel = $this->connection->channel();
        $channel->basic_qos(null, 1, null);
        $channel->basic_consume(self::QUEUE_NAME, '', false, false, false, false, function (AMQPMessage $msg) use ($callback) {
            $message = new Job($msg->body);
            if($callback($message)){
                $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
            }
        });

        $count = 0;
        $timeout = 1;
        while (count($channel->callbacks) && $count < $maxJobs) {
            try{
                $channel->wait(null, false , $timeout);
                $count++;
            }catch(\PhpAmqpLib\Exception\AMQPTimeoutException $e){
                $channel->close();
            }
        }

        $channel->close();
    }
}