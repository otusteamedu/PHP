#!/usr/local/bin/php

<?php

class Caller
{
    private $message;
    private $socketFile;

    public function __construct($file) 
    {
        $this->socketFile = $file;
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
    private function writeToSocket(): void
    {
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_connect($socket, $this->socketFile);
        socket_write($socket, $this->message, strlen($this->message));
        socket_close($socket);
    }

    public function __get($item) 
    {
        if ($item === 'writeToSocket') $this->writeToSocket();
    }

}

(new Caller('/usr/src/mysite.local/app/sockets/new.sock'))->writeToSocket;