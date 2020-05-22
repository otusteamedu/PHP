<?php
namespace Otus;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Otus\ActiveRecord\AttributeValue;

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
        print ' [x] Adding ' . $msg->body . ' rows' . PHP_EOL;
        $startTime = hrtime(true);

        $result = AttributeValue::addRandomRows($this->pdo, (int) $msg->body);

        $endTime = hrtime(true);
        $execTime = round(($endTime - $startTime) / 1000000, 0);

        if ($result === true) {
            print ' [x] Request to add ' . $msg->body . ' rows executed in ' . $execTime . ' msec' . PHP_EOL . PHP_EOL;
        } else {
            print ' [x] Error is occurred during attempt to add new rows' . PHP_EOL . PHP_EOL;
        }

        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    }
}
