<?php

namespace App\Socket;

use App\IO\Output\Output;
use Exception;

class Server
{
    /** @var Output */
    private $output;
    /** @var UnixSocket */
    private $socket;
    /** @var int */
    private $messageCount = 0;

    /**
     * @param Output $output
     * @param string|null $socketPath
     * @throws Exception
     */
    public function __construct(Output $output, string $socketPath = null)
    {
        $this->output = $output;

        $this->socket = new UnixSocket();

        $this->socket->bind($socketPath);
    }

    public function run()
    {
        while (1) {
            if ($this->messageCount === 0) {
                $this->output->writeLn('Waiting for messages...');
            }

            $message = $this->receive();

            $this->messageCount++;

            $this->output->writeLn("{$this->messageCount}. Message from sender: {$message->content}");

            $this->sendAnswer($message);
        }
    }

    public function exit()
    {
        $this->socket->close();
    }

    protected function receive(): Message
    {
        return $this->socket->setBlock()->receive();
    }

    protected function sendAnswer(Message $message): int
    {
        return $this->socket
            ->setNonBlock()
            ->send("Message \"{$message->content}\" received", $message->from);
    }
}
