<?php


namespace Otushw\Queue\RabbitMQ;

use Otushw\Logger\AppLogger;
use Otushw\Queue\QueueConsumerInterface;
use Otushw\ServerQueue\Jobs\Worker;

class RabbitMQConsumer extends RabbitMQ implements QueueConsumerInterface
{

    public function consume(): void
    {
        AppLogger::addInfo('RabbitMQ:Consumer was ran');

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
        AppLogger::addInfo('RabbitMQ:Consumer received message', [$msg->body]);
        $worker = new Worker($msg->body);
        $job = $worker->create();
        $job->do();
        if ($job->isCompleted()) {
            $worker->finish();
            $this->channel->basic_ack($msg->delivery_info['delivery_tag']);
        }
    }

}
