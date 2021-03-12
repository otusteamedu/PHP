<?php


namespace Sockets;


class clientSocket extends mainSocket
{

    private $connectedSocket;

    /**
     * Инициализация сокета
     */
    protected function initSocket()
    {
        parent::chooseDomain();
        $this->socket = new \Sockets\socket("$this->host", "$this->port", "$this->domain");
        $this->socket->create();
        $this->socket->connect();
    }

    public function start():void
    {
        $exitMessages = [
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
