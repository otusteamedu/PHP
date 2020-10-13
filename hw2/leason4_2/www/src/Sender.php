<?php
/**
 * Читаем из stdin и отправляем через сокет.
 * Все что пришло из сокета - выводим в stdout
 *
 * @author Petr Ivanov (petr.yrs@gmail.com)
 */

use helper\SocketServer;
use helper\SocketClient;

class Sender
{
    private $socket;
    private $stdin;
    private $isServer = false;


    public function __construct($path, $isServer = false)
    {
        $this->isServer = $isServer;
        $this->connect($path);
        $this->stdin = fopen('php://stdin', 'r');
        if ($this->stdin) {
            stream_set_blocking($this->stdin, 0);
        } else {
            new Exception('Не возможно открыть stdin для чтения');
        }
        if ($this->isServer) {
            echo "run SERVER \n";
        } else {
            echo "run CLIENT \n";
        }
    }


    /**
     * Connect to socket
     *
     * @param string $path socket URI
     */
    private function connect($path)
    {
        if ($this->isServer) {
            $this->socket = new SocketServer($path);
        } else {
            $this->socket = new SocketClient($path);
        }
    }


    /**
     * Main function
     */
    public function run()
    {
        if ( ! $this->socket->isConnected()) {
            new Exception('Не удалось установить подключение');

            return false;
        }
        while (true) {
            //echo sprintf("%s %s \n",date('H:i:s'), ($this->isServer) ? 'Server' : 'Client');

            if (!$this->isServer) {
                $socketData = $this->socket->read();
                if ( ! empty($socketData)) {
                    echo sprintf("Client say: %s \n", $socketData);
                }
            } else {
                $stdinData = fgets($this->stdin);
                if ( ! empty($stdinData)) {
                    $this->socket->write($stdinData);
                }
            }

            sleep(1);
        }
    }
}