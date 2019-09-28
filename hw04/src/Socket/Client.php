<?php

namespace App\Socket;

use App\IO\Input\Input;
use App\IO\Output\Output;

class Client
{
    /** @var Input */
    private $input;
    /** @var Output */
    private $output;
    /** @var UnixSocket */
    private $socket;

    public function __construct(Input $input, Output $output, string $sockFile = null)
    {
        $this->input = $input;
        $this->output = $output;

        $this->socket = new UnixSocket();
        $this->socket->bind($sockFile);
    }

    public function run(string $to, string $breakCommand = 'quit'): int
    {
        $continue = true;

        $messagesCount = 0;

        while ($continue) {
            $line = $this->input->readLn("Your message (\"$breakCommand\" for exit): ");

            if ($line === $breakCommand) {
                $continue = false;
                continue;
            }

            $this->send($line, $to);

            $this->receiveAndPrint();

            $messagesCount++;
        }

        return $messagesCount;
    }

    public function exit(): void
    {
        $this->socket->close();
    }

    protected function send(string $message, string $to): int
    {
        $this->socket->setNonBlock();

        $sentBytes = $this->socket->send($message, $to);

        $this->socket->setBlock();

        return $sentBytes;
    }

    protected function receiveAndPrint(): void
    {
        $message = $this->socket->receive();

        $this->output->writeLn("Message from receiver: {$message->content}");
    }
}
