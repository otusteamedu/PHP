<?php


namespace Repetitor202;


class Client
{
    use SocketTrait;

    public function __construct()
    {
        echo 'Client' . PHP_EOL;
        $this->createSocket();
    }

    public function sendData()
    {
        while(true){
            try {
                echo '>> Insert message: ';
                $msg = trim(fgets(STDIN, 1024));
                $len = strlen($msg);
                socket_sendto($this->socket, $msg, $len, 0, $this->socketFile, 0);
                echo 'Message has been received by server: ' . $msg . PHP_EOL;
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

        }
    }
}