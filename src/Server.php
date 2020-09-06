<?php

namespace App;

class Server
{
    private $socket;
    /**
     * @var AbstractLog
     */
    private $log;
    private $run = false;

    public function __construct($socket, AbstractLog $log)
    {
        if (!extension_loaded('sockets')) {
            throw new SocketException('Расширение на сокет не установлено.');
        }
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!socket_bind($this->socket, $socket))
            throw new SocketException("Невозможно привязаться к $socket");
        $this->log = $log;
        $this->log->INFO('Сервер запущен');
        $this->run();

        $this->closeSocket($socket);
    }

    public function run()
    {
        $this->run = true;
        do {
            $this->readMsg();
        } while ($this->run);
    }

    public function readMsg()
    {
        if (!$this->run)
            throw new SocketException('Сервер не запущен!');

        if (!socket_set_block($this->socket))
            throw new SocketException('Не удалось сокет переключить блокирущий режим ');
        $msg = '';
        $from = '';
        $this->log->INFO('Ждем сообщение ...');
        $bytes_received = socket_recvfrom($this->socket, $msg, 65536, 0, $from);
        if ($bytes_received == -1)
            throw new SocketException('Произошла ошибка при чтении из сокета');
        $this->parseMsg($msg, $from);
    }

    public function writeMsg($msg, $from)
    {
        if (!$this->run)
            throw new SocketException('Сервер не запущен!');

        if (!socket_set_nonblock($this->socket))
            throw new SocketException('Не удалось перевести сокет в неблокирующий режим');

        $len = strlen($msg);
        $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $from);

        if ($bytes_sent == -1)
            throw new SocketException('Произошла ошибка при отправке из сокета');
        else if ($bytes_sent != $len)
            throw new SocketException("$bytes_sent  байт отправлено, ожидалось отправка $len байт");

        $this->log->INFO("Сообщение $msg отправлено клиенту '$from', байт: $len");
        return true;
    }

    public function parseMsg($msg, $from)
    {
        if (!$this->run)
            throw new SocketException('Сервер не запущен!');

        if ($msg == 'stop') {
            $msg = 'FROM:' . $from . ' отправил команду stop';
            $this->log->INFO($msg);
            if ($this->writeMsg($msg, $from)) {
                sleep(1);
                $this->run = false;
            }
        } else {
            $this->log->INFO($msg);
            $this->writeMsg($msg, $from);
        }
    }

    public function closeSocket($socket)
    {
        if ($this->run) {
            $this->log->WARNING('Серевер запущен!');
        }
        $this->log->INFO('Сервер завершил работу');
        socket_close($this->socket);
        unlink($socket);
    }
}