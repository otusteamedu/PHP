<?php

namespace Chat;
class Server{
    private $socket = null;
    public function __construct(string $socketAddr)
    {
        if(file_exists($socketAddr)){
            unlink($socketAddr);
        }

        if(!$this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0)){
            throw new \Exception('Error while creating socket');
        }

        if(!socket_bind($this->socket, $socketAddr)){
            throw new \Exception('Error while socket binding');
        }

        if(!socket_listen($this->socket)){
            throw new \Exception('Error while socket listen');
        }

    }

    public function run(){
        $socket = socket_accept($this->socket);
        while(true){

            $message = socket_read($socket, 1024);

            if($message === false){
                socket_close($this->socket);
                exit;
            }

            $message = trim($message);

            if($message){
                echo 'From client: '.$message."\n";

                socket_write($socket, "From server: ".$message);
            }

            sleep(1);

        }
    }
}
