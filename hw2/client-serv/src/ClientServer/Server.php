<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 13.12.20
 * Time: 0:00
 */

namespace ClientServer;

class Server
{
    protected $server;
    function __construct($socket_path, $domain = AF_UNIX, $type = SOCK_STREAM, $protocol = 0)
    {
        $this->server = new Socket($socket_path, $domain , $type, $protocol);
        $this->server->initServer($this->server->getSocket());
    }

    public function run(){
        $socketAccept = $this->server->accept($this->server->getSocket());

        while (true) {
            $buf = $this->server->read($socketAccept);
            echo "Received: $buf \n";
            if ($buf === 'exit') {
                break;
            }
            $massage = '';
            switch (mb_strtolower($buf)) {
                case 'hi':
                case 'hello':
                    $message = 'Hi!';
                    break;
                case 'how are you':
                    $message = "I'm fun, and you?";
                    break;
                case 'goodbuy':
                case 'buy':
                    $message = "See you letter!";
                    break;
                default:
                    $message = "Everything is doing for the best!";
                    break;
            }
            //$message = $this->server->readSTDIN();
            $this->server->write($socketAccept, $message);
        }
    }

}