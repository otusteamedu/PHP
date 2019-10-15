<?php

class ServerClass
{

    private $server_side_sock;
    private $socket;
    private $stop_server = false;

    public function __construct($server_side_sock)
    {
        $this->server_side_sock = $server_side_sock;
        $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
    }

    public function run()
    {
        socket_bind($this->socket, $this->server_side_sock);

        while (!$this->stop_server)
        {
            socket_set_block($this->socket);
            echo sprintf("%s\tГотов получить сообщение...%s", date("Y-m-d H:i:s"), PHP_EOL);

            $buf = $from = '';
            socket_recvfrom($this->socket, $buf, 65536, 0, $from);
            echo sprintf("%s\tПолучил: <%s> от: <%s>%s", date("Y-m-d H:i:s"), $buf, $from, PHP_EOL);

            if ($buf === 'X-Quit') {
                $this->stop_server = true;
            }

            $buf = sprintf("X-Response%s%s", PHP_EOL, $buf);
            $len = strlen($buf);

            socket_set_nonblock($this->socket);
            socket_sendto($this->socket, $buf, $len, 0, $from);

            echo sprintf("%s\tЗапрос обработан%s", date("Y-m-d H:i:s"), PHP_EOL);
        }

        $this->stop();
    }

    private function stop()
    {
        socket_close($this->socket);
        unlink($this->server_side_sock);
        echo sprintf("%s\tОстановился.%s", date("Y-m-d H:i:s"), PHP_EOL);
    }
}