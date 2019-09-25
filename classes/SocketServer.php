<?php


class SocketServer
{
    private $locaSocket = 'tcp://0.0.0.0:8000';

    public function run()
    {
        $socket = stream_socket_server($this->locaSocket, $errno, $errstr);
        if (!$socket) {
            throw new Exception("$errstr ($errno)\n");
        }

        while ($connect = stream_socket_accept($socket, -1)) {
            $message = fread($connect, 1024);
            echo 'Пришло: ' . $message;
            $head = "HTTP/1.1 200 OK\r\n" .
                "Content-Type: text/html\r\n" .
                "Body: Это сервер\r\n" .
                "Connection: close\r\n";

            fwrite($connect, $head);
            fclose($connect);
        }

        fclose($socket);
    }
}




