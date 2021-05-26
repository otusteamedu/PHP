<?php


namespace App\Service\Messenger;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

interface ChannelBuilderInterface
{
    public function build(): AMQPChannel;
    public function setQueueName(string $queueName): self;
    public function getQueueName(): string;
    public function getConnection(): AMQPStreamConnection;
}
