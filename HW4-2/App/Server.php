<?php


namespace App;


use Socket\Socket;

class Server
{

    private Socket $socket_master;
    private array $slave_sockets = Array();
    public array $read_sockets = Array();
    private Bool $abort = false;

    public function __construct()
    {
        $this->initSocket();
        $this->listenServer();
    }

    private function initSocket()
    {
        $this->socket_master = new Socket($_ENV['SOCKET_PATH'], $_ENV['SOCKET_PORT']);
        $this->socket_master->create();
        $this->socket_master->bind();
    }

    private function listenServer()
    {
        $this->socket_master->listen();
        $this->read_sockets = [$this->socket_master->getSocket()];


        while (!$this->abort) {
            $read = $this->read_sockets;
            $num_changed = Socket::select($read);
            $this->read_sockets = $read;

            /* Изменилось что-нибудь? */
            if ($num_changed) {
                $this->readServer();
            }

            $this->read_sockets = $this->slave_sockets;
            $this->read_sockets[] = $this->socket_master->getSocket();
        }

        $this->socket_master->close();
    }

    private function readServer()
    {
        /* Изменился ли главный сокет (новое подключение) */

        if (in_array($this->socket_master->getSocket(), $this->read_sockets)) {
            $this->slave_sockets[] = $this->socket_master->accept();
        }
        /* Цикл по всем клиентам с проверкой изменений в каждом из них */
        foreach ($this->slave_sockets as $key => $client) {
            /* Новые данные в клиентском сокете? Прочитать и ответить */
            if (in_array($client, $this->read_sockets)) {
                $input = Socket::read($client);

                if ($input === false) {
                    Socket::shutdown($client);
                    unset($this->slave_sockets[$key]);
                } else {
                    $input = trim($input);
                    echo $input . PHP_EOL;
                }

                if ($input == 'quit') {
                    Socket::shutdown($this->socket_master->getSocket());
                    $this->abort = true;
                }

            }

        }
    }

}