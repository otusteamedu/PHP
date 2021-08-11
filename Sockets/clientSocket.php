<?php


namespace Sockets;


use Exception;

class clientSocket extends mainSocket
{

    /**
     * Инициализация сокета
     * @throws Exception
     */
    protected function initSocket()
    {
        parent::chooseDomain();
        $this->socket = new \Sockets\socket(
            $host = $this->host,
            $port = $this->port,
            $domain = $this->domain);
        $this->socket->create();
        $this->socket->connect();
    }

    /**
     * @throws Exception
     */
    public function start():void
    {
        $exitMessages = [
            'stop',
            'quit',
            'exit',
            '\q',
            'bye',
            'Bye',
            'goodbye',
            'Goodbye',
            'GoodBye',
        ];
        do {
            $this->socket->putToSocket($this->getMessage());
            $msg = $this->socket->getFromSocket();
            if ($msg) {
                echo "Server says: " . $msg . PHP_EOL;
                if (in_array($msg, $exitMessages)) {
                    $this->socket->closeSocket();
                    break;
                }
            }
        }
        while (true);
    }
}
