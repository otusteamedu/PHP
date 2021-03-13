<?php


namespace Otushw\Queue\RabbitMQ;

use Otushw\Queue\QueueConsumerInterface;
use Otushw\Message;

class RabbitMQConsumer extends RabbitMQ implements QueueConsumerInterface
{

    public function consume(): void
    {
        $this->channel->basic_qos(null, 1, null);
        $this->channel->basic_consume(
            self::QUEUE_NAME,
            '',
            false,
            false,
            false,
            false,
            [$this, 'processMessage']
        );

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function processMessage($msg): void
    {
        $data = json_decode($msg->body);
        if (!empty($data)) {
            foreach ($data as $item) {
                Message::showMessage($item);
            }
            $this->channel->basic_ack($msg->delivery_info['delivery_tag']);
        }
    }

    public function run(): void
    {
        $this->consume();
    }

}
