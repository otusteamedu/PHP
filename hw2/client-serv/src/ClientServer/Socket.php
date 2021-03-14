<?php
/**
 * Created by PhpStorm.
 * User: rainbow
 * Date: 13.12.20
 * Time: 12:46
 */

namespace ClientServer;

use Exception;

class Socket
{
    protected $socket;
    protected $serverSocket;
    protected $socket_path;
    protected $portSocket = 9000;

    function __construct($socket_path, $domain = AF_UNIX, $type = SOCK_STREAM, $protocol = 0)
    {
        $this->socket_path = $socket_path;
        $this->socket = socket_create($domain, $type, $protocol);
    }

    function initServer(){
        if (file_exists($this->socket_path)) {
            unlink("$this->socket_path");
        }
        $bind = socket_bind($this->socket, $this->socket_path, $this->portSocket);
        //chmod("$this->socket", "0702");
        if (empty($bind)) {
            throw new Exception("Can't bind socket ".$this->socket_path);
        }
        socket_listen($this->socket);
    }
    function initClient() {
        $connect = socket_connect($this->socket, $this->socket_path, $this->portSocket);
        if (empty($connect)) {
            throw new Exception("Can't connect socket ".$this->socket_path);
        }
    }

    function accept($socket){
        $socketAccept = socket_accept($socket);
        if (empty($socketAccept)) {
            throw new Exception("Can't accept socket");
        }
        return $socketAccept;
    }

    function read($socket, int $long = 4096) {
        $mess = socket_read($socket, $long);
        if ($mess === false) {
            throw new Exception("Can't read socket");
        }
        return $mess;
    }

    function readline(string $mess = "Write mess: "){
        if ($mess === false) {
            throw new Exception("Can't read socket");
        }
        return readline($mess);
    }

    function write($socket, $client_message){
        $result = socket_write($socket, $client_message);
        if ($result === false) {
            throw new Exception("Can't write in socket".$socket);
        }
        return $result;
    }

    public function readSTDIN()
    {
        return trim(fgets(STDIN));
    }

    public function getSocket(){
        return $this->socket;
    }

    public function getServerSocket(){
        return $this->serverSocket;
    }

    public function __destruct()
    {
        socket_shutdown($this->socket, 2);
        socket_close($this->socket);
    }
}