<?php

namespace nlazarev\hw4\Model\Sockets;

class ServerUnixSocket extends UnixSocket
{
    protected static $socket_chmod = 0702;
    protected static $socket_listen_backlog = 1;
    protected static $socket_read_buf = 2048;
    protected static $socket_read_type = PHP_BINARY_READ;

    private $clients = array();

    public function __construct(string $path_to_socket)
    {
        parent::__construct();

        $socket = $this->instance;

        if ($this->ext_loaded
         && get_resource_type($socket) == "Socket") {

            if (file_exists($path_to_socket)) {
                unlink($path_to_socket);
            }

            if (@socket_bind($socket, $path_to_socket)) {
                chmod($path_to_socket, static::$socket_chmod);
            } else {
                $this->setErrorMsg();
                socket_close($socket);
                return;
            }

            if (!@socket_listen($socket, static::$socket_listen_backlog)) {
                $this->setErrorMsg();
                socket_close($socket);
                return;
            }

            if (!@socket_set_nonblock($socket)) {
                $this->setErrorMsg();
                socket_close($socket);
                return;               
            }
            
            $this->socket_ok = true;
        }
    }

    public function processClientsConnections(int $max_clients): bool
    {
        $socket = $this->instance;
        $clients = $read = $this->clients;
        $read[] = $socket; 

        if (@socket_select($read, $write = null, $except = null, 0) > 0) {
            if (in_array($socket, $read)) {
                if ($client = @socket_accept($socket))  {
                    if (count($clients) < $max_clients) {
                        $clients[] = $client;
                    } else {
                        if (@socket_write($client, "[Server] No more free connections \n")) {
                            if (!@socket_shutdown($client)) {
                                $this->setErrorMsg();
                                return false;    
                            }
                        } else {
                            $this->setErrorMsg();
                            return false;
                        } 
                    }                   
                } else {
                    $this->setErrorMsg();
                    return false;                  
                }
            }

            foreach ($clients as $key => $client) {
                if (in_array($client, $read)) {
                    if (!($data = @socket_read($client, static::$socket_read_buf, static::$socket_read_type))) {
                        if (@socket_shutdown($client)) {
                            unset($clients[$key]);
                        } else {
                            $this->setErrorMsg();
                            return false;
                        }
                    } else {
                        if (!@socket_write($client, "[Server] Message received \n")) {
                            $this->setErrorMsg();
                            socket_close($client);
                            unset($clients[$key]);
                            return false;
                        }
                    }
                }
            }
            
            $this->clients = $clients;
/*
            print_r($this->clients) . PHP_EOL;
            print_r($read) . PHP_EOL;
            echo $num . PHP_EOL;
*/
        }
        return true;
 #       return $this->clients;
    }

    public function getClientsCount(): int
    {
        return count($this->clients);
    } 
}