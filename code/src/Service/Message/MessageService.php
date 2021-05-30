<?php


namespace App\Service\Message;


use App\Message\MessageInterface;
use App\Utils\Builder\AMQPChannelBuilderInterface;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Message\AMQPMessage;

class MessageService implements MessageServiceInterface
{
    private AMQPChannel $channel;
    private string $queue;

    /**
     * BankStatementMessageService constructor.
     * @param AMQPChannelBuilderInterface $channelBuilder
     */
    public function __construct(AMQPChannelBuilderInterface $channelBuilder)
    {
        $this->channel = $channelBuilder->build();
        $this->queue = $channelBuilder->getQueueName();
    }

    /**
     * Добавление сообщения в очередь.
     *
     * @param \App\Message\MessageInterface $message
     */
    public function push(MessageInterface $message)
    {
        $body = json_encode(serialize($message));

        $msg = new AMQPMessage($body, [
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        $this->channel->basic_publish($msg, '', $this->queue);
        $this->channel->close();
    }
}
