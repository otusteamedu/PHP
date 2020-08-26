<?php


namespace App;


use App\Socket\Socket;
use Exception;

class Client extends Socket
{
    public function __construct($iniFilepath)
    {
        parent::__construct($iniFilepath);

        if (socket_connect($this->socket, $this->socketPath) === false) {
            return new Exception('failed to connect to socket');
        }
    }

    public function start($message)
    {
        $messageLength = strlen($message);

        while (true) {
            $sent = socket_write($this->socket, $message, $messageLength);
            if ($sent === false || $sent >= $messageLength) {
                break;
            }
            $message = substr($message, $sent);
            $messageLength -= $sent;
        }
    }
}