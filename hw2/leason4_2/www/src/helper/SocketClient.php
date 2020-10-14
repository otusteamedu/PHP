<?php

namespace helper;
/**
 * Class SocketClient
 *
 * @package helper
 * @author  Petr Ivanov (petr.yrs@gmail.com)
 */
class SocketClient extends AbstractSocket
{
    private $conStr = '';


    /**
     * SocketHelper constructor.
     *
     * @param string $conStr путь к файлу сокета
     */
    public function __construct($conStr)
    {
        $this->conStr = $conStr;
        $this->init();
    }


    /**
     * Подключение к сокету
     */
    private function init()
    {
        if ($this->socket) {
            fclose($this->socket);
        }

        $this->socket = stream_socket_client($this->conStr, $errno, $errstr);
        if (empty($this->socket)) {
            new \Exception(( ! empty($errstr)) ? $errstr : sprintf('Не могу подключиться к %s - %s', $this->conStr, $errstr));
        }

        return $this;
    }


    /**
     * Получить сообщение
     *
     * @return string
     */
    public function read()
    {
        $this->buffer = '';

        $this->buffer = fgets($this->socket);
        if (!empty($this->buffer)) {
            $this->init();
        }

        return $this->buffer;
    }


    /**
     * Отправить сообщение
     *
     * @param string $msg сообщение
     *
     * @return false|int
     */
    public function write($msg)
    {
        return fwrite($this->socket, $msg);
    }
}