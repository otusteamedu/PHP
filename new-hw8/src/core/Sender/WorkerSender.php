<?php
namespace AYakovlev\core\Sender;

use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class WorkerSender
{
    private array $bunny;
    private AMQPStreamConnection $connection;
    public function __construct()
    {
        $this->bunny = (require __DIR__ . '/../../../config/settings.php')['rabbitmq'];
        $this->connection = new AMQPStreamConnection(
            $this->bunny['host'],
            $this->bunny['port'],
            $this->bunny['user'],
            $this->bunny['password']
        );
    }

    /**
     * @param int $invoiceNum - номер накладной
     * @throws Exception
     */
    public function execute(int $invoiceNum): void
    {
        $channel = $this->connection->channel();
        $channel->queue_declare(
            'invoice_queue',
            false,
            true,       // Очередь сохраняется
            false,
            false
        );

        $msg = new AMQPMessage(
            $invoiceNum,
            ['delivery_mode' => 2]  // сообщение постоянное
        );

        $channel->basic_publish(
            $msg,
            '',
            'invoice_queue'
        );

        $channel->close();
        $this->connection->close();
    }
}
