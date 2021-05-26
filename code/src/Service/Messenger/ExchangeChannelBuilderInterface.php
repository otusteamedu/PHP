<?php


namespace App\Service\Messenger;


use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

interface ExchangeChannelBuilderInterface
{
    public function build(): AMQPChannel;
    public function setExchangeType(string $exchangeType): self;
    public function setExchangeName(string $exchangeName): self;
    public function getExchangeName(): string;
    public function getExchangeType(): string;
    public function getConnection(): AMQPStreamConnection;
}
