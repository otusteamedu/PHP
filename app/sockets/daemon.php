<?php


class Daemon 
{
    
    private $socketFile;
    private $socket;
    private $messege;
    private $resultFile = 'result.txt';
    private $socketPath = '/var/spool/sockets/';

    public function __construct($file) 
    {
        $this->socketFile = $this->socketPath.$file;
        $this->createSocket();
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
     * Запись результата в файл
     */
    private function putMessage() 
    {
        try {
            if (!file_put_contents($this->socketPath.$this->resultFile, $this->messege, FILE_APPEND | LOCK_EX)) {
                throw new Exception('Не удалось создать файл для записи');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * стартует демона на прослушивание
     */
    public function startDaemon() 
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
                $this->messege = socket_read($accept, 2048);
                if (false === $this->messege) { 
                    echo "Ошибка: ".socket_strerror(socket_last_error()).""; 
                    break 2; 
                   
                } else { 
                    if (trim($this->messege) == "") break; 
                    else $this->putMessage();
                   
                }
            }
        }

        unlink($this->socketFile);
        socket_close($this->socket);

    }

}


(new Daemon('new.sock'))->startDaemon();


