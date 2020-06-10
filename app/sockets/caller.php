#!/usr/local/bin/php

<?php

class Caller
{
    private $message;
    private $socketFile;
    private $socketPath = '/var/spool/sockets/';

    public function __construct($file) 
    {
        $this->socketFile = $this->socketPath.$file;
        $this->generateMessage();
    }
    /**
     * функция-генератор сообщений
     */
    private function generateMessage():void
    {
        $date = date('h:i:s');
        $this->message = "Привет из скрипта в $date" . PHP_EOL;
    }

    /**
     * функция отправки данных в сокет
     */
    public function writeToSocket(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($socket, $this->socketFile);
        socket_write($socket, $this->message, strlen($this->message));
        socket_close($socket);
    }

}

(new Caller('new.sock'))->writeToSocket();