<?php

class SocketClient
{
    private $remote_socket = "tcp://0.0.0.0:8000";

    public function __construct($remote_socket = null)
    {
        $this->remote_socket = $remote_socket ?? $this->remote_socket;
    }

    public function send_query($head)
    {
        $fp = stream_socket_client($this->remote_socket, $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            fwrite($fp, $head);
            while (!feof($fp)) {
                echo fgets($fp, 1024);
            }
            fclose($fp);
        }

    }
}

$head = "GET / HTTP/1.1\r\n" .
    "Host:  0.0.0.0:8000\r\n" .
    "Accept: */*\r\n" .
    "Body: Это клиент\r\n";

$socketClient = new SocketClient();
$socketClient->send_query($head);

