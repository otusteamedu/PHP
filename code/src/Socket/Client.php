<?php
namespace Socket;

final class Client
{

private Socket $socket;

    public function __construct(string $host, int $port)
    {
        $this->initSocket($host, $port);
    }

    public function waitForMessage()
    {
        echo 'Enter Message: ';
        $this->message($this->readline());
    }

    private function message(string $message)
    {
        $this->socket->write($message);
        $this->waitingResponse();
    }

    private function initSocket(string $host, int $port): void
    {
        $this->socket = new Socket($host, $port);
        $this->socket->create();
        $this->socket->connect();
    }

    private function readline(): string
    {
        return rtrim(fgets(STDIN));
    }

    private function waitingResponse(): void
    {
        $message = $this->socket->read();

        echo "Server says:\t" . $message . PHP_EOL;
        if ($message === 'quit') {
            $this->socket->close();
            return;
        }

        $this->waitForMessage();
    }
}