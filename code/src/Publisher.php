<?php

namespace src;

use Closure;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Publisher
{
    private AMQPChannel $channel;

    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBIT_CONTAINER_NAME'],
            $_ENV['RABBIT_PORT'],
            $_ENV['RABBIT_USER'],
            $_ENV['RABBIT_PASS']
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('hello');
    }

    /**
     * @throws \ErrorException
     */
    public function listen()
    {
        echo " [*] Waiting for messages. To exit press CTRL+C\n";
        $callback = $this->getQueueCallback();
        $this->channel->basic_consume('hello', '',
            false, true, false, false, $callback);
        $this->listenQueue();
    }

    /**
     * @throws \Exception
     */
    private function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }

    /**
     * @throws \ErrorException
     * @throws \Exception
     */
    private function listenQueue()
    {
        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
        $this->closeConnection();
    }

    private function getQueueCallback(): Closure
    {
        return function ($msg) {
            echo ' [x] Sending message to ', $msg->body, "\n";
            $this->sendMessage($msg->body);
        };
    }

    private function sendMessage(string $email)
    {
        $send = mail($email, 'rabbit', 'Message from rabbit queue');
        if ($send) {
            echo 'The message has sent';
        } else {
            echo 'Error of message sending';
        }
    }
}