<?php


class Client {

    private $socket = null;
    private $client_file_socket = null;
    private $server_file_socket = null;
    public function __construct($ini_file) {
        try {
            if(!is_readable($ini_file)) throw new Exception("INI file not exists");
            $ini = parse_ini_file($ini_file, true);
            if(!isset($ini["client"])) throw new Exception("Client config is empty");
            if(!isset($ini["client"]["socket_file"])) throw new Exception("Socket file for client is empty in config file");
            if(!isset($ini["server"])) throw new Exception("Server config is empty");
            if(!isset($ini["server"]["socket_file"])) throw new Exception("Socket file for server is empty in config file");
            $this->client_file_socket = $ini["client"]["socket_file"];
            $this->server_file_socket = $ini["server"]["socket_file"];
        } catch (Exception $e) {
            echo $e->getMessage()."\n";
        }
    }

    public function start($msg) {
        try {
            $this->socket = socket_create(AF_UNIX, SOCK_DGRAM, 0);
            if(!$this->socket) throw new Exception("Unable to create AF_UNIX socket");
            if(!socket_bind($this->socket, $this->client_file_socket)) {
                throw new Exception("Unable to bind to ".$this->client_file_socket);
            }
            if(!socket_set_nonblock($this->socket)) throw new Exception("Unable to set nonblocking mode for socket");
            if(trim($msg) == "") $msg = "message";
            $len = strlen($msg);
            $sent = socket_sendto($this->socket, $msg, $len, 0, $this->server_file_socket);
            if($sent == -1) throw new Exception("An error occured while sending to the socket");
            else if ($sent != $len) throw new Exception("$sent bytes have been sent insted of the $len bytes expected");
            if(!socket_set_block($this->socket)) {
                throw new Exception("Unable to set blocking mode for socket");
            }
            $buf = "";
            $from = "";
            $received = socket_recvfrom($this->socket, $buf, 65536, 0, $from);
            if($received == -1) throw new Exception("An error occured while receiving from the socket");
            echo "$buf\n";


        } catch (Exception $e) {
            echo $e->getMessage()."\n";
        } finally {
            if($this->socket != null)
                socket_close($this->socket);
            unlink($this->client_file_socket);
        }


    }
}