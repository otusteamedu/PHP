<?php


namespace App;


class Client
{
    private $server;
    private $socket;
    private $msg;
    /**
     * @var TextLog
     */
    private $log;

    /**
     * Client constructor.
     * @param $server
     * @param $client
     * @param $msg
     * @param $log
     */
    public function __construct($server, $client, $msg, $log)
    {
        $this->server = $server;
        $this->msg = $msg;
        $this->log = $log;

        if (!extension_loaded('sockets')) {
            throw new SocketException('Расширение на сокет не установлено.');
        }
        // создаем unix udp socket
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        if (!$this->socket)
            throw new SocketException('Не удалось создать AF_UNIX сокет');

        // Сокет привязывается к пути. Не требуется, если только отправлять, и не получать
        if (!socket_bind($this->socket, $client))
            throw new SocketException("Невозможно привязаться к $client");

        $this->sendMsg($msg);
        $this->closeSocket($client);
    }

    public function sendMsg($msg)
    {
        // Используем сокет для отправке данных
        if (!socket_set_nonblock($this->socket))
            throw new SocketException('Не удалось перевести сокет в неблокирующий режим');

        $len = strlen($msg);
        // Нам известно имя сокета сервера и сервер запущен и слушает сокет
        $bytes_sent = socket_sendto($this->socket, $msg, $len, 0, $this->server);

        if ($bytes_sent == -1)
            throw new SocketException('Произошла ошибка при отправке в сокет');
        else if ($bytes_sent != $len)
            throw new SocketException("$bytes_sent  байт отправлено, ожидалось отправка $len байт");

        $this->log->INFO("Сообщение $msg отправлено на сервер '$this->server', байт: $len");
        $this->readMsg();
    }

    public function readMsg()
    {
        // Переключаем сокет на чтение
        if (!socket_set_block($this->socket))
            throw new SocketException('Не удалось сокет переключить блокирущий режим');
        $buf = '';
        $from = '';
        // Блокируем и ждем ответа от сервера
        $bytes_received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        if ($bytes_received == -1)
            throw new SocketException('Произошла ошибка при чтении из сокета');
        $this->log->INFO("Получено '$buf' от '$from'");
    }

    public function closeSocket($socket)
    {
        socket_close($this->socket);
        unlink($socket);
    }
}