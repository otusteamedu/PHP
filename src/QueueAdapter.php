<?php
namespace Otus;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Otus\ActiveRecord\AttributeValue;
use Otus\ActiveRecord\AsyncRequestStatus;

final class QueueAdapter
{
    private $connection;
    private $channel;
    private const QUEUE_NAME = 'otus_hw16';
    private $pdo;

    public function __construct(string $host, string $user, string $pass, int $port, \PDO $pdo)
    {
        $this->connection = new AMQPStreamConnection($host, $port, $user, $pass);
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(self::QUEUE_NAME, false, true, false, false);

        $this->pdo = $pdo;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }

    public function pushMsg(string $message): void
    {
        $msg = new AMQPMessage(
            $message,
            [
                'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
            ]
        );
        $this->channel->basic_publish($msg, '', self::QUEUE_NAME);
    }

    /**
     * @throws \ErrorException
     */
    public function consuming(): void
    {
        $this->channel->basic_consume(self::QUEUE_NAME, '', false, false, false, false, [$this, 'callback']);

        while ($this->channel->is_consuming()) {
            $this->channel->wait();
        }
    }

    public function callback(AMQPMessage $msg): void
    {
        $startTime = hrtime(true);
        $arMsg = explode(':', $msg->body);
        print ' [*] Adding ' . $arMsg[1] . ' rows (request #' . $arMsg[0] . ')' . PHP_EOL;

        $reqStatus = new AsyncRequestStatus($this->pdo);
        $reqStatus->setId((int) $arMsg[0]);
        $result = AttributeValue::addRandomRows($this->pdo, (int) $arMsg[1]);

        $endTime = hrtime(true);
        $execTime = round(($endTime - $startTime) / 1000000, 0);

        if ($result === true) {
            $reqStatus
                ->setStatus(2)
                ->update();
            print ' [x] Request #' . $arMsg[0] . ' to add ' . $arMsg[1] . ' rows executed in ' . $execTime . ' msec' . PHP_EOL . PHP_EOL;
        } else {
            $reqStatus
                ->setStatus(3)
                ->update();
            print ' [x] Error is occurred during attempt to add new rows' . PHP_EOL . PHP_EOL;
        }

        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }
}
