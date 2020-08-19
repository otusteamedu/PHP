<?php


namespace Penguin\Sockets;


class Server
{
    protected Socket $socket;
    protected AcceptSocket $socketAccept;
    protected string $host;

    public function __construct(string $host, int $port)
    {
        $this->host = $host;

        $this->clearHost();

        $this->socket = new Socket($host, $port);
    }

    public function run()
    {
        $this->socket->bind();
        $this->socket->listen(7);
        echo 'Server init' . PHP_EOL;
        do {
            $this->socketAccept = $this->socket->accept();
            $response = $this->socketAccept->read(2048);

            if ($response == 'quit') {
                $this->socketAccept->write('off..');
                break;
            }

            echo 'Client message: ' . $response . PHP_EOL;

            $talkBack = 'Pong';
            $this->socketAccept->write($talkBack);
        } while (true);

        $this->socket->close();
    }

    private function clearHost()
    {
        if (file_exists($this->host)) {
            unlink($this->host);
        }
    }

    public function __destruct()
    {
        $this->clearHost();
    }
}