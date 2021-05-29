<?php


namespace App\Utils\Builder;


use PhpAmqpLib\Channel\AMQPChannel;

interface AMQPChannelBuilderInterface
{
    public function build(): AMQPChannel;
    public function setQueueName(string $queueName): self;
    public function getQueueName(): string;
}
