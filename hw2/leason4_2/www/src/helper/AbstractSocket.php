<?php

namespace helper;

class AbstractSocket implements ISocket
{
    public $socket;
    public $buffer = '';


    public function read()
    {
        // TODO: Implement read() method.
    }


    public function write($msg)
    {
        // TODO: Implement write() method.
    }


    public function isConnected()
    {
        return ! empty($this->socket);
    }


    /**
     * При удалении объекта
     */
    public function __destruct()
    {
        // закрываем текущие соединение
        if ($this->socket) {
            stream_socket_shutdown($this->socket, 0);
        }
    }


    /**
     * Получить ресурс сокета
     *
     * @return mixed
     */
    public function getResource()
    {
        return $this->socket;
    }


    /**
     * Последнее полученное сообщение
     *
     * @return string
     */
    public function getLastMsg()
    {
        return $this->buffer;
    }
}