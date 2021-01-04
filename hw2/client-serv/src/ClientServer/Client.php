<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 12.12.20
 * Time: 23:59
 */

namespace ClientServer;


class Client
{
    protected $client;
    function __construct($socket_path, $domain = AF_UNIX, $type = SOCK_STREAM, $protocol = 0)
    {
        $this->client = new Socket($socket_path, $domain, $type, $protocol);
        $this->client->initClient($this->client->getSocket());
    }

    public function run(){

        while (true) {
            echo 'Enter Message:';
            $message = $this->client->readSTDIN();
            $socket = $this->client->getSocket();
            $this->client->write($socket, $message);
            $buf = $this->client->read($socket, 4096);
            echo "Server answer:" . $buf ."\n";
            if ($message === 'exit') {
                break;
            }
        }

    }
}