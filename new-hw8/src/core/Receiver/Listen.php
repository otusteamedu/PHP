<?php


namespace AYakovlev\core\Receiver;


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Listen
{
    private WorkerReceiver $workerReceiver;
    private array $bunny;
    private AMQPStreamConnection $connection;

    public function __construct(WorkerReceiver $workerReceiver)
    {
        $this->workerReceiver = $workerReceiver;
        $this->bunny = (require __DIR__ . '/../../../config/settings.php')['rabbitmq'];
        $this->connection = new AMQPStreamConnection(
            $this->bunny['host'],
            $this->bunny['port'],
            $this->bunny['user'],
            $this->bunny['password']
        );
    }

    /**
     * @param AMQPMessage $msg
     */
    public function process(AMQPMessage $msg): void
    {
        $message = 'Received message No. ' . $msg->body;
        $this->workerReceiver->getLog()->info($message);
        echo "-----\n";
        echo $message . "\n";

        $this->workerReceiver->generatePdf()->sendEmail();
        echo "Message No. {$msg->body} processed.\n";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);

    }

    public function listen()
    {
        $this->workerReceiver->getLog()->info('Begin listen routine');

        $channel = $this->connection->channel();

        $channel->queue_declare(
            'invoice_queue',
            false,
            true, // постоянная очередь
            false,
            false
        );

        $channel->basic_qos(
            null,
            1,
            null
        );

        $channel->basic_consume(
            'invoice_queue',
            '',
            false,
            false,
            false,
            false,
            array($this, 'process')
        );

        $this->workerReceiver->getLog()->info('Consuming from queue');

        while (count($channel->callbacks)) {
            $this->workerReceiver->getLog()->info('Waiting for incoming messages');
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }
}