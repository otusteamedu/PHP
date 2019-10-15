<?php

class ClientClass
{

    private $client_side_sock;
    private $socket;

    public function __construct($client_side_sock)
    {
        $this->client_side_sock = $client_side_sock;
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
        socket_bind($this->socket, $this->client_side_sock);
    }

    public function send($to, $msg)
    {
        socket_set_nonblock($this->socket);
        $len = strlen($msg);
        socket_sendto($this->socket, $msg, $len, 0, $to);

        $this->getAnsver();
    }

    private function getAnsver() 
    {
        socket_set_block($this->socket);
        $buf = $from = '';
        socket_recvfrom($this->socket, $buf, 65536, 0, $from);
        echo sprintf("Получил от: <%s>%s<%s>%s", $from, PHP_EOL, $buf, PHP_EOL);
    }

    public function stop()
    {
        socket_close($this->socket);
        unlink($this->client_side_sock);

        echo sprintf("Остановился.%s", PHP_EOL);
    }
}