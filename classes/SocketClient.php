<?php

class SocketClient
{
    private $remoteSocket = "tcp://0.0.0.0:8000";

    public function __construct($remoteSocket = null)
    {
        $this->remoteSocket = $remoteSocket ?? $this->remoteSocket;
    }

    public function sendQuery($head)
    {
        $fp = stream_socket_client($this->remoteSocket, $errno, $errstr, 30);
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

