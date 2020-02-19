<?php

namespace App;

final class Server
{
    private Socket $socket;

    /**
     * @param Socket $socket
     */
    public function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    /**
     * @throws SocketException
     */
    public function run(): void
    {
        self::log('Started');
        while (true) {
            $this->loop();
            usleep(1);
        }
    }

    /**
     * @throws SocketException
     */
    private function loop(): void
    {
        self::log('Ready to receive...');

        $buf = '';
        $from = '';
        $this->socket->recvFrom($buf, $from);
        self::log('Received: ' . $buf);

        $this->socket->sendTo('Message received: ' . $buf, $from);
        self::log('Request processed');
    }

    /**
     * @param string $msg
     */
    private static function log(string $msg): void
    {
        echo $msg . PHP_EOL;
    }
}
