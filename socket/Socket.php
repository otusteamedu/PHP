<?php

namespace Ozycast\Socket;

use Ozycast\Socket\Client;
use Ozycast\Socket\Server;

class Socket
{
    const ERROR_CODE_DISCONNECT = 10054;
    protected $path = "temp/sock.sock";

    public final function run()
    {
        if (!isset($_SERVER['argv'][1]))
            return "Empty argument";

        if ($_SERVER['argv'][1] == "server")
            (new Server())->start();
        else
            (new Client())->start();

    }

    public function read($connect)
    {
        $msg = @socket_read($connect, 2048);
        if (strlen($msg))
            echo date("H:i", time())." ".$connect." > ". $msg, PHP_EOL;
    }

    public function send($connect, $message)
    {
        socket_write($connect, $message. PHP_EOL, strlen($message));
    }
}