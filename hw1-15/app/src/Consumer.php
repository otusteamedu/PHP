<?php

namespace src;

use Closure;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consumer
{
    private AMQPChannel $channel;

    private AMQPStreamConnection $connection;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection(
            $_ENV['RABBIT_HOST'],
            $_ENV['RABBIT_PORT'],
            $_ENV['RABBIT_USER'],
            $_ENV['RABBIT_PASSWORD']
        );
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('email-queue');
    }


    public function listen()
    {
        $callback = $this->getCallback();
        $this->channel->basic_consume('email-queue', '',
            false, true, false, false, $callback);
        $this->listenQueue();
    }

    private function closeConnection()
    {
        $this->channel->close();
        $this->connection->close();
    }

    private function listenQueue()
    {
        while ($this->channel->is_open()) {
            $this->channel->wait();
        }
        $this->closeConnection();
    }

    private function getCallback(): Closure
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
            echo 'Message has sent';
        } else {
            echo 'Error of message sending';
        }
    }
}
