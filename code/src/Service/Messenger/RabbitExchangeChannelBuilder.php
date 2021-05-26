<?php


namespace App\Service\Messenger;


use App\Service\Messenger\Exception\ExchangeTypeInvalidException;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;


class RabbitExchangeChannelBuilder implements ExchangeChannelBuilderInterface
{
    const TYPE_DIRECT = 'direct';
    const TYPE_TOPIC = 'topic';
    const TYPE_HEADERS = 'headers';
    const TYPE_FANOUT = 'fanout';


    private AMQPStreamConnection $connection;
    private string $exchangeName;
    private string $exchangeType;

    /**
     * RabbitExchangeChannelBuilder constructor.
     * @param \PhpAmqpLib\Connection\AMQPStreamConnection $connection
     * @param string $exchangeName
     * @param string $exchangeType
     */
    public function __construct(
        AMQPStreamConnection $connection,
        string $exchangeName = 'app-exchange',
        string $exchangeType = self::TYPE_FANOUT
    )
    {
        $this->connection = $connection;
        $this->exchangeName = $exchangeName;
        $this->exchangeType = $exchangeType;
    }

    public function setExchangeName(string $exchangeName): self
    {
        $this->exchangeName = $exchangeName;
        return $this;
    }

    public function setExchangeType(string $exchangeType): self
    {
        $types = [self::TYPE_DIRECT, self::TYPE_FANOUT, self::TYPE_HEADERS, self::TYPE_TOPIC];

        if (!in_array($exchangeType, $types)) {
            throw new ExchangeTypeInvalidException();
        }

        $this->exchangeType = $exchangeType;

        return $this;
    }


    public function build(): AMQPChannel
    {
        $channel = $this->connection->channel();

        $channel->exchange_declare(
            $this->exchangeName,
            $this->exchangeType,
            false, false, false
        );

        return $channel;
    }

    public function getExchangeName(): string
    {
        return $this->exchangeName;
    }

    public function getExchangeType(): string
    {
        return $this->exchangeType;
    }

    public function getConnection(): AMQPStreamConnection
    {
        return $this->connection;
    }
}
