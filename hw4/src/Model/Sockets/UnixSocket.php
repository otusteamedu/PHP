<?php

namespace nlazarev\hw4\Model\Sockets;

abstract class UnixSocket
{
    protected $ext_loaded = false;
    protected $instance = null;
    protected $socket_ok = false;
    private $error_msg = 'Socket error: no errors';

    protected function __construct()
    {
        if (extension_loaded('sockets')) {
            $this->ext_loaded = true;			
        } else {
            $this->setErrorMsg();
            return;
        }

        if ($socket = @socket_create(AF_UNIX, SOCK_STREAM, 0)) {
            $this->instance = $socket;
        } else {
            $this->setErrorMsg();
            return;
        }
    }

    protected function setErrorMsg()
    {
        if (!$this->ext_loaded) {
            $this->error_msg = "Socket error: extension 'sockets' not loaded \n";
        } else {
            $errorcode = socket_last_error($this->instance);
            $errormsg = socket_strerror($errorcode);
            $this->error_msg = "Socket error: [$errorcode] $errormsg \n";
        }
    }

    public function getErrorMsg(): string
    {
        return $this->error_msg;
    }

    public function isSocketOk(): bool
    {
        if ($this->socket_ok) {
            return true;
        } else 
            return false;
    }

    public function getInstance() { //TODO: разобраться, как вернуть resource при declare(strict_types=1);
        if (get_resource_type($this->instance) == "Socket") {
            return $this->instance;
        }
    }

}