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
        try {
            $this->socket = new \Sockets\socket("$this->host", "$this->port", "$this->domain");
            $this->socket->create();
            $this->socket->connect();
        } catch (\Exception $exception) {
            die("Error:". $exception->getCode().". " . $exception->getMessage() . PHP_EOL);
        }
    }

    public function start()
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