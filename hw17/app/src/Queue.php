<?php
/**
 * Class wrapper for PhpAmqpLib functions
 *
 * @author Evgeny Prokhorov <prohorov-evgen@ya.ru>
 *
 */
namespace Jekys;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Queue
{
    /**
     * @var string - queue name
     */
    private $name;

    /**
     * @var PhpAmqpLib\Connection\AbstractConnection
     */
    private $connection;

    /**
     * @var PhpAmqpLib\Channel\AbstractChannel
     */
    private $channel;

    /**
     * Class entitiy constructor
     * Creates connections to the RabbitMQ and makes channel there
     *
     * @param string $host
     * @param int $port
     * @param string $user
     * @param string $password
     * @param string $name
     *
     * @return void
     */
    public function __construct(
        string $host,
        int $port,
        string $user,
        string $password,
        string $name = 'main'
    ) {
        $this->name = $name;

        $this->connection = new AMQPStreamConnection(
            $host,
            $port,
            $user,
            $password
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare(
            $this->name,
            false,
            false,
            false,
            false
        );
    }

    /**
     * Add new message to the queue
     *
     * @param string $msg
     *
     * @return bool
     */
    public function sendMessage(string $msg): bool
    {
        $msg = new AMQPMessage($msg);
        $this->channel->basic_publish(
            $msg,
            '',
            $this->name
        );

        return true;
    }

    /**
     * Returns one message from the queue
     *
     * @return null|string
     */
    public function getMessage(): ?string
    {
        return $this->channel->basic_get(
            $this->name,
            true
        )->body;
    }

    /**
     * Class object destructor
     * Closes all connections with MQ server
     *
     * @return void
     */
    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
