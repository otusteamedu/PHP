<?php 

namespace Server;

class Start
{

    private $socket;
    private $socket_dir;

    public function __construct() 
    {
        $this->socket_dir = "../".$_ENV['SOCKET_DIR']."/";
    }

    public function run()
    {
        $this->clearTmp();
        $this->createSocket();
        $this->bindSocket();
        $this->listenSocket();
        $this->runServer();
    }

    private function createSocket()
    {
        $this->socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
    }

    private function bindSocket()
    {
        socket_bind($this->socket,  $this->socket_dir.$_ENV['SOCKET_FILE'], $_ENV['PORT']);
    }

    private function listenSocket()
    {
        socket_listen($this->socket, $_ENV['MAX_CONNECTIONS']);
    }

    private function getClientMessage($accept_socket)
    {
        return socket_read($accept_socket, 1024);
    }

    private function getServerResponse()
    {
        return trim(fgets(STDIN));
    }

    private function sendResponse($server_response, $accept_socket)
    {
        socket_write($accept_socket, $server_response, strlen($server_response));
    }

    private function runServer()
    {
        while (true) {
    
            echo "Ожидаем сообщений от клиента \n";
        
            while($accept_socket = socket_accept($this->socket)) {
        
                $message = $this->getClientMessage($accept_socket);
                echo "Клиент сказал: " . $message . "\n";
                echo "Что ответит сервер? \n";
                $server_response = $this->getServerResponse();
                $this->sendResponse($server_response, $accept_socket);
            }    
        }

    }

    private function clearTmp(){
        $socket_files = scandir($this->socket_dir);

        foreach($socket_files as $socket_file){
            if($socket_file == $_ENV['SOCKET_FILE']){
                unlink($this->socket_dir.$_ENV['SOCKET_FILE']);
            }
        }
        
    }
}