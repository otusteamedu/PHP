<?php

trait DaemonSayTrait 
{
    private $phrase;
    private function sayHello(): void
    {
        $this->$phrase = 'привет, братишка!';
    }

    private function sayHowAreYou(): void
    {
        $this->$phrase = 'привет, какие дела?';
    }
}


class Daemon 
{
    use DaemonSayTrait;
    
    private $socketFile;
    private $socket;

    public function __construct($file) 
    {
        $this->socketFile = $file;
        $this->createSocket();
        $this->phrase = $this->sayHowAreYou();
    }

    /**
     * функция соединения с сокетом;
     */
    private function createSocket(): void 
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
        socket_bind($this->socket, $this->socketFile);
        socket_listen($this->socket);
    }

    /**
     * стартует демона на прослушивание
     */
    private function startDaemon() 
    {
             
        while(true) { 
            
            try {
                $accept = socket_accept($this->socket); 
                if($accept < 0) {
                    throw new Exception("Ошибка: ". socket_strerror(socket_last_error())."");
                    break;
                } 
            } catch(Exception $e) {
                echo $e->getMessage();
            }

            while(true) { 
                $messege = socket_read($accept, 2048);
                if (false === $messege) { 
                    echo "Ошибка: ".socket_strerror(socket_last_error()).""; 
                    break 2; 
                } else { 
                    if (trim($messege) == "") break; 
                    else file_put_contents('result.txt', $messege, FILE_APPEND | LOCK_EX); 
                }
            }
        }

        unlink($this->socketFile);
        socket_close($this->socket);

    }

    public function __get($item)
    {
        if ($item = 'startDaemon') $this->startDaemon();
    }
}




(new Daemon('new.sock'))->startDaemon;


